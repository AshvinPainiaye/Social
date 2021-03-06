<?php

namespace Social\Bundle\Controller;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Social\Bundle\Entity\AddFriend;
use Social\Bundle\Form\AddFriendType;

use Social\Bundle\Entity\User;


class ProfileController extends Controller
{
  /**
  * Show the user
  */
  public function showAction(Request $request, $id)
  {

    $userId = $this->getUser();
    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('SocialBundle:User')->findAll();

    // if (!is_object($user) || !$user instanceof UserInterface) {
    //     throw new AccessDeniedException('This user does not have access to this section.');
    // }

    $posts = $em->getRepository('SocialBundle:Post')->findAll();

    $addFriend = new AddFriend();
    $addFriend->setDate(new \DateTime('now'));
    $formAddFriend = $this->createForm('Social\Bundle\Form\AddFriendType', $addFriend);
    $formAddFriend->handleRequest($request);


    $userEnvoie = $this->getUser();
    $userEnvoie->getId();

    $username = $em->getRepository('SocialBundle:User')->findOneById($id);
    $friend = $em->getRepository('SocialBundle:AddFriend')->findBy(['receptionFriend'=>$username]);
    $follower = $em->getRepository('SocialBundle:AddFriend')->findAll();


    if ($formAddFriend->isSubmitted() && $formAddFriend->isValid()) {
      $addFriend->setEnvoieFriend($userEnvoie)->setReceptionFriend($username);
      $em = $this->getDoctrine()->getManager();
      $em->persist($addFriend);
      $em->flush();

       return $this->redirectToRoute('fos_user_profile_show',  array('id'=> $id, 'user' => $username ));

    }

    return $this->render('FOSUserBundle:Profile:show.html.twig', array(
      'user' => $user,
      'posts' => $posts,
      'addFriend' => $addFriend,
      'formAddFriend' => $formAddFriend->createView(),
      'friend' => $friend,
      'follower' => $follower,
    ));
  }

  /**
  * Edit the user
  */
  public function editAction(Request $request)
  {
    $user = $this->getUser();
    $userId = $user->getId();
    if (!is_object($user) || !$user instanceof UserInterface) {
      throw new AccessDeniedException('This user does not have access to this section.');
    }

    /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
    $dispatcher = $this->get('event_dispatcher');

    $event = new GetResponseUserEvent($user, $request);
    $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);

    if (null !== $event->getResponse()) {
      return $event->getResponse();
    }

    /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
    $formFactory = $this->get('fos_user.profile.form.factory');

    $form = $formFactory->createForm();
    $form->setData($user);

    $form->handleRequest($request);

    if ($form->isValid()) {
      /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
      $userManager = $this->get('fos_user.user_manager');

      $event = new FormEvent($form, $request);
      $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);

      $userManager->updateUser($user);

      if (null === $response = $event->getResponse()) {
        $url = $this->generateUrl('fos_user_profile_show', array('id'=> $userId, 'user' => $user));
        $response = new RedirectResponse($url);
      }

      $dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

      return $response;
    }

    return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
      'form' => $form->createView()
    ));
  }



  public function showFriendAction(AddFriend $addFriend)
  {
      $deleteForm = $this->createDeleteForm($addFriend);
      return $this->render('addfriend/show.html.twig', array(
          'addFriend' => $addFriend,
          'delete_form' => $deleteForm->createView(),
      ));
  }

  public function deleteAction(Request $request, AddFriend $addFriend)
  {
      $form = $this->createDeleteForm($addFriend);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->remove($addFriend);
          $em->flush();
      }
       return $this->redirectToRoute('homepage');
  }

  public function createDeleteForm(AddFriend $addFriend)
  {
      return $this->createFormBuilder()
      ->setAction($this->generateUrl('addfriend_delete', array('id1'=>$user=$this->getUser()->getId(), 'user1'=>$user=$this->getUser(), 'id' => $addFriend->getId())))
          ->setMethod('DELETE')
          ->getForm()
      ;
  }


}
