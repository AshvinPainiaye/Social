<?php

namespace Social\Bundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Social\Bundle\Entity\AddFriend;
use Social\Bundle\Form\AddFriendType;

/**
 * AddFriend controller.
 *
 * @Route("/addfriend")
 */
class AddFriendController extends Controller
{
    // /**
    //  * Lists all AddFriend entities.
    //  *
    //  * @Route("/", name="addfriend_index")
    //  * @Method("GET")
    //  */
    // public function indexAction()
    // {
    //     $em = $this->getDoctrine()->getManager();
    //
    //     $addFriends = $em->getRepository('SocialBundle:AddFriend')->findAll();
    //
    //     return $this->render('addfriend/index.html.twig', array(
    //         'addFriends' => $addFriends,
    //     ));
    // }

    // /**
    //  * Creates a new AddFriend entity.
    //  *
    //  * @Route("/new", name="addfriend_new")
    //  * @Method({"GET", "POST"})
    //  */
    // public function newAction(Request $request)
    // {
    //     $addFriend = new AddFriend();
    //     $form = $this->createForm('Social\Bundle\Form\AddFriendType', $addFriend);
    //     $form->handleRequest($request);
    //
    //     $userId = $this->getUser();
    //     $userId->getId();
    //     $addFriend->setUser1($userId);
    //
    //     $userId2 = $this->getUser();
    //     $userId2->getId();
    //     $addFriend->setUser2($userId2);
    //
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($addFriend);
    //         $em->flush();
    //
    //         return $this->redirectToRoute('addfriend_show', array('id' => $addFriend->getId()));
    //     }
    //
    //     return $this->render('addfriend/new.html.twig', array(
    //         'addFriend' => $addFriend,
    //         'form' => $form->createView(),
    //     ));
    // }

    /**
     * Finds and displays a AddFriend entity.
     *
     * @Route("/{id}", name="addfriend_show")
     * @Method("GET")
     */
    public function showAction(AddFriend $addFriend)
    {
        $deleteForm = $this->createDeleteForm($addFriend);

        return $this->render('addfriend/show.html.twig', array(
            'addFriend' => $addFriend,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    // /**
    //  * Displays a form to edit an existing AddFriend entity.
    //  *
    //  * @Route("/{id}/edit", name="addfriend_edit")
    //  * @Method({"GET", "POST"})
    //  */
    // public function editAction(Request $request, AddFriend $addFriend)
    // {
    //     $deleteForm = $this->createDeleteForm($addFriend);
    //     $editForm = $this->createForm('Social\Bundle\Form\AddFriendType', $addFriend);
    //     $editForm->handleRequest($request);
    //
    //     if ($editForm->isSubmitted() && $editForm->isValid()) {
    //         $em = $this->getDoctrine()->getManager();
    //         $em->persist($addFriend);
    //         $em->flush();
    //
    //         return $this->redirectToRoute('addfriend_edit', array('id' => $addFriend->getId()));
    //     }
    //
    //     return $this->render('addfriend/edit.html.twig', array(
    //         'addFriend' => $addFriend,
    //         'edit_form' => $editForm->createView(),
    //         'delete_form' => $deleteForm->createView(),
    //     ));
    // }

    /**
     * Deletes a AddFriend entity.
     *
     * @Route("/{id}", name="addfriend_delete")
     * @Method("DELETE")
     */
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

    /**
     * Creates a form to delete a AddFriend entity.
     *
     * @param AddFriend $addFriend The AddFriend entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AddFriend $addFriend)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('addfriend_delete', array('id' => $addFriend->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
