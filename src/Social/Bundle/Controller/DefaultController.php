<?php

namespace Social\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Social\Bundle\Entity\Post;
use Social\Bundle\Form\PostType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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

    $actualites = $em->getRepository('SocialBundle:AddFriend')->findAll();

    $post = new Post();
    $post->setDate(new \DateTime('now'));
    $formPost = $this->createForm('Social\Bundle\Form\PostType', $post);
    $formPost->handleRequest($request);

    $securityContext = $this->container->get('security.authorization_checker');
    if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
      $userId = $this->getUser();
      $userId->getId();
      $post->setUser($userId);
      $posts = $em->getRepository('SocialBundle:Post')->findBy(['user'=>$userId]);

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
      'actualites' => $actualites,
    ));

  }








  /**
  * Ajouter un like sur un post
  * @Method({"GET", "POST"})
  * @Route("post/{id}/like", name="post_like_new")
  */
  public function LikeDislikeToPost(Post $post, Request $request) {
    $user = $this->getUser();
    $listeLike = $post->getLike();
    if ($listeLike->contains($user)) {
      $post->removeLike($user);
      $user->removePostlike($post);
    } else {
      $user->addPostlike($post);
      $post->addLike($user);
    }
    $em = $this->getDoctrine()->getManager();
    $em->persist($post);
    $em->flush();
    return $this->redirectToRoute('homepage');
  }
















}
