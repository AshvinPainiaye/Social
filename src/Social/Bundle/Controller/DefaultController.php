<?php

namespace Social\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Social\Bundle\Entity\Post;
use Social\Bundle\Form\PostType;
use Social\Bundle\Form\SearchType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
  /**
  * @Route("/", name="homepage", options={"expose"=true})
  */
  public function indexAction(Request $request)
  {
    $formFactory = $this->get('fos_user.registration.form.factory');
    $form = $formFactory->createForm();

    $em = $this->getDoctrine()->getManager();
    $posts = $em->getRepository('SocialBundle:Post')->findAll();
    $allUser = $em->getRepository('SocialBundle:User')->findAll();
    $actualites = $em->getRepository('SocialBundle:AddFriend')->findAll();

    $post = new Post();
    $post->setDate(new \DateTime('now'));
    $formPost = $this->createForm('Social\Bundle\Form\PostType', $post);
    $formPost->handleRequest($request);



    $formSearch = $this->createForm(new SearchType());
    $request = $this->getRequest();
    if($request->getMethod() == 'POST')
    {
      $formSearch->bind($request);
      if($formSearch->isValid())
      {
        $em = $this->getDoctrine()->getManager();
        //On récupère les données entrées dans le formulaire par l'utilisateur
        $data = $this->getRequest()->request->get('recherche_user');
        $rechercheUser = $em->getRepository('SocialBundle:User')->findBy(['username'=>$data]);
        return $this->render('search.html.twig', array('rechercheUser' => $rechercheUser));
      }
    }


    $securityContext = $this->container->get('security.authorization_checker');
    if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
      $userId = $this->getUser();
      $userId->getId();
      $post->setUser($userId);
      $posts = $em->getRepository('SocialBundle:Post')->findBy(['user'=>$userId]);
    }


        if ($formPost->isValid()) {
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
      'formSearch' => $formSearch->createView(),
      'allUser' => $allUser,
    ));
  }


  /**
  * Ajouter un like sur un post
  * @Method({"GET", "POST"})
  * @Route("post/{id}/like", name="post_like_new", options={"expose"=true})
  */
  public function LikeDislikeToPost(Post $post, Request $request) {
    $user = $this->getUser();
    $listeLike = $post->getLike();

    $em = $this->getDoctrine()->getManager();
    $serializer = $this->get('jms_serializer');
    if ($request->isXmlHttpRequest()) {
      if ($listeLike->contains($user)) {
        $post->removeLike($user);
        $user->removePostlike($post);
        $em->persist($post);
        $em->flush();
        $checkLikers = $this->getDoctrine()->getRepository(Post::class)->find($post)->getLike();
        $serialized = $serializer->serialize(count($checkLikers), 'json');
        return new JsonResponse($serialized, 200);
      } else {
        $user->addPostlike($post);
        $post->addLike($user);
        $em->persist($post);
        $em->flush();
        $checkLikers = $this->getDoctrine()->getRepository(Post::class)->find($post)->getLike();
        $serialized = $serializer->serialize(count($checkLikers), 'json');
        return new JsonResponse($serialized, 200);
      }
    }
    return $this->redirectToRoute('homepage');
  }




  /**
  * notification
  * @Route("notification", name="notification")
  */
  public function notificationAction() {
    $userId = $this->getUser();
    $userId->getId();

    $em = $this->getDoctrine()->getManager();
    $follow = $em->getRepository('SocialBundle:AddFriend')->findBy(['receptionFriend' => $userId]);

    $like = $em->getRepository('SocialBundle:Post')->findBy(['user' => $userId]);
    $comment = $em->getRepository('SocialBundle:Commentaire')->findAll();



    return $this->render('notification.html.twig', array(
      'follow' => $follow,
      'like' => $like,
      'comment' => $comment,
    ));

  }




}
