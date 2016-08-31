<?php

namespace Social\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Social\Bundle\Entity\Post;
use Social\Bundle\Form\PostType;

use Social\Bundle\Entity\Commentaire;
use Social\Bundle\Form\CommentaireType;

/**
* Post controller.
*
* @Route("/post")
*/
class PostController extends Controller
{
  /**
  * Lists all Post entities.
  *
  * @Route("/", name="post_index")
  * @Method("GET")
  */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getManager();

    $posts = $em->getRepository('SocialBundle:Post')->findAll();

    return $this->render('post/index.html.twig', array(
      'posts' => $posts,
    ));
  }

  /**
  * Creates a new Post entity.
  *
  * @Route("/new", name="post_new")
  * @Method({"GET", "POST"})
  */
  public function newAction(Request $request)
  {
    $post = new Post();
    $form = $this->createForm('Social\Bundle\Form\PostType', $post);
    $form->handleRequest($request);

    $userId = $this->getUser();
    $userId->getId();
    $post->setUser($userId);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($post);
      $em->flush();

      return $this->redirectToRoute('post_show', array('id' => $post->getId()));
    }

    return $this->render('post/new.html.twig', array(
      'post' => $post,
      'form' => $form->createView(),
    ));
  }

  /**
  * Finds and displays a Post entity.
  *
  * @Route("/{id}", name="post_show")
  * @Method({"GET", "POST"})
  */
  public function showAction(Post $post, Request $request)
  {
    $deleteForm = $this->createDeleteForm($post);

    $commentaire = new Commentaire();
    $commentaire->setDate(new \DateTime('now'));
    $formComment = $this->createForm('Social\Bundle\Form\CommentaireType', $commentaire);
    $formComment->handleRequest($request);

    $userId = $this->getUser();
    $userId->getId();
    $commentaire->setUser($userId);

    $post->getId();
    $commentaire->setPost($post);

    $em = $this->getDoctrine()->getManager();

    $commentaires = $em->getRepository('SocialBundle:Commentaire')->findBy(array('post' =>$post->getId()));

    if ($formComment->isSubmitted() && $formComment->isValid()) {
      $em->persist($commentaire);
      $em->flush();

      return $this->redirectToRoute('post_show', array('id' => $post->getId()));
    }


    return $this->render('post/show.html.twig', array(
      'post' => $post,
      'delete_form' => $deleteForm->createView(),
      'commentaire' => $commentaire,
      'formComment' => $formComment->createView(),
      'commentaires' => $commentaires,
    ));
  }






  /**
  * Displays a form to edit an existing Post entity.
  *
  * @Route("/{id}/edit", name="post_edit")
  * @Method({"GET", "POST"})
  */
  public function editAction(Request $request, Post $post)
  {
    $deleteForm = $this->createDeleteForm($post);
    $editForm = $this->createForm('Social\Bundle\Form\PostType', $post);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($post);
      $em->flush();

      return $this->redirectToRoute('post_edit', array('id' => $post->getId()));
    }

    return $this->render('post/edit.html.twig', array(
      'post' => $post,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ));
  }

  /**
  * Deletes a Post entity.
  *
  * @Route("/{id}", name="post_delete")
  * @Method("DELETE")
  */
  public function deleteAction(Request $request, Post $post)
  {
    $form = $this->createDeleteForm($post);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($post);
      $em->flush();
    }

    return $this->redirectToRoute('post_index');
  }

  /**
  * Creates a form to delete a Post entity.
  *
  * @param Post $post The Post entity
  *
  * @return \Symfony\Component\Form\Form The form
  */
  private function createDeleteForm(Post $post)
  {
    return $this->createFormBuilder()
    ->setAction($this->generateUrl('post_delete', array('id' => $post->getId())))
    ->setMethod('DELETE')
    ->getForm()
    ;
  }
}
