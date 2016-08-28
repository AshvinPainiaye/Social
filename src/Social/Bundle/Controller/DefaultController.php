<?php

namespace Social\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Social\Bundle\Entity\Post;
use Social\Bundle\Form\PostType;


use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
  /**
  * @Route("/")
  */
  public function indexAction(Request $request)
  {
    $formFactory = $this->get('fos_user.registration.form.factory');
    $form = $formFactory->createForm();

    $em = $this->getDoctrine()->getManager();
    $posts = $em->getRepository('SocialBundle:Post')->findAll();

    $post = new Post();
    $formPost = $this->createForm('Social\Bundle\Form\PostType', $post);
    $formPost->handleRequest($request);

    $securityContext = $this->container->get('security.authorization_checker');
    if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
      $userId = $this->getUser();
      $userId->getId();
      $post->setUser($userId);
    }

    if ($formPost->isSubmitted() && $formPost->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($post);
      $em->flush();

      return $this->redirectToRoute('homepage');
    }

    return $this->render('SocialBundle:Default:index.html.twig', array(
      'posts' => $posts,
      'post' => $post,
      'formPost' => $formPost->createView(),
      'form' => $form->createView(),
    ));

  }



  // /**
  // * @Route("/profil/{id}", name="show_User_Profile")
  // */
  // public function showUserAction()
  // {
  //
  //   $em = $this->getDoctrine()->getManager();
  //   $user = $em->getRepository('SocialBundle:User')->findAll();
  //
  //
  //     return $this->render('profile/profile.html.twig', array(
  //         'user' => $user,
  //     ));
  // }

}
