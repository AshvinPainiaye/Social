<?php

namespace Social\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Social\Bundle\Entity\Messages;
use Social\Bundle\Form\MessagesType;

/**
* Messages controller.
*
* @Route("/message")
*/
class MessagesController extends Controller
{
  /**
  * Lists all Messages entities.
  *
  * @Route("/", name="messages_index")
  * @Method("GET")
  */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();

    $messages = $em->getRepository('SocialBundle:Messages')->findAll();
    $users = $em->getRepository('SocialBundle:User')->findAll();


    return $this->render('messages/index.html.twig', array(
      'messages' => $messages,
      'users' => $users,
    ));
  }

  /**
  * Creates a new Messages entity.
  *
  * @Route("/{recepteur}", name="messages_new")
  * @Method({"GET", "POST"})
  */
  public function newAction(Request $request, $recepteur=null)
  {
    $message = new Messages();
    $form = $this->createForm('Social\Bundle\Form\MessagesType', $message);
    $form->handleRequest($request);

    $em = $this->getDoctrine()->getManager();
    $recepteur = $em->getRepository('SocialBundle:User')->findOneById($recepteur);
    $recepteurId = $recepteur->getId();

    $userId = $this->getUser();
    $userId->getId();
    $message->setEmetteur($userId)->setRecepteur($recepteur);

    $conversation = $em->getRepository('SocialBundle:Messages')->findConversation($userId, $recepteur);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($message);
      $em->flush();

      return $this->redirectToRoute('messages_new', array('recepteur' => $recepteurId ));
    }

    return $this->render('messages/conversation.html.twig', array(
      'message' => $message,
      'form' => $form->createView(),
      'conversation' => $conversation
    ));
  }

  /**
  * Finds and displays a Messages entity.
  *
  * @Route("/{id}", name="messages_show")
  * @Method("GET")
  */
  public function showAction(Messages $message)
  {
    $deleteForm = $this->createDeleteForm($message);

    return $this->render('messages/show.html.twig', array(
      'message' => $message,
      'delete_form' => $deleteForm->createView(),
    ));
  }

  // /**
  // * Displays a form to edit an existing Messages entity.
  // *
  // * @Route("/{id}/edit", name="messages_edit")
  // * @Method({"GET", "POST"})
  // */
  // public function editAction(Request $request, Messages $message)
  // {
  //   $deleteForm = $this->createDeleteForm($message);
  //   $editForm = $this->createForm('Social\Bundle\Form\MessagesType', $message);
  //   $editForm->handleRequest($request);
  //
  //   if ($editForm->isSubmitted() && $editForm->isValid()) {
  //     $em = $this->getDoctrine()->getManager();
  //     $em->persist($message);
  //     $em->flush();
  //
  //     return $this->redirectToRoute('messages_edit', array('id' => $message->getId()));
  //   }
  //
  //   return $this->render('messages/edit.html.twig', array(
  //     'message' => $message,
  //     'edit_form' => $editForm->createView(),
  //     'delete_form' => $deleteForm->createView(),
  //   ));
  // }
  //
  // /**
  // * Deletes a Messages entity.
  // *
  // * @Route("/{id}", name="messages_delete")
  // * @Method("DELETE")
  // */
  // public function deleteAction(Request $request, Messages $message)
  // {
  //   $form = $this->createDeleteForm($message);
  //   $form->handleRequest($request);
  //
  //   if ($form->isSubmitted() && $form->isValid()) {
  //     $em = $this->getDoctrine()->getManager();
  //     $em->remove($message);
  //     $em->flush();
  //   }
  //
  //   return $this->redirectToRoute('messages_index');
  // }
  //
  // /**
  // * Creates a form to delete a Messages entity.
  // *
  // * @param Messages $message The Messages entity
  // *
  // * @return \Symfony\Component\Form\Form The form
  // */
  // private function createDeleteForm(Messages $message)
  // {
  //   return $this->createFormBuilder()
  //   ->setAction($this->generateUrl('messages_delete', array('id' => $message->getId())))
  //   ->setMethod('DELETE')
  //   ->getForm()
  //   ;
  // }
}
