<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Commentary;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Commentary controller.
 *
 * @Route("commentary")
 */
class CommentaryController extends Controller
{
    /**
     * Lists all commentary entities.
     *
     * @Route("/", name="commentary_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commentaries = $em->getRepository('AppBundle:Commentary')->findAll();

        return $this->render('commentary/index.html.twig', array(
            'commentaries' => $commentaries,
        ));
    }

    /**
     * Creates a new commentary entity.
     *
     * @Route("/new", name="commentary_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $commentary = new Commentary();
        $form = $this->createForm('AppBundle\Form\CommentaryType', $commentary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commentary);
            $em->flush($commentary);

            return $this->redirectToRoute('commentary_show', array('id' => $commentary->getId()));
        }

        return $this->render('commentary/new.html.twig', array(
            'commentary' => $commentary,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a commentary entity.
     *
     * @Route("/{id}", name="commentary_show")
     * @Method("GET")
     */
    public function showAction(Commentary $commentary)
    {
        $deleteForm = $this->createDeleteForm($commentary);

        return $this->render('commentary/show.html.twig', array(
            'commentary' => $commentary,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing commentary entity.
     *
     * @Route("/{id}/edit", name="commentary_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Commentary $commentary)
    {
        $deleteForm = $this->createDeleteForm($commentary);
        $editForm = $this->createForm('AppBundle\Form\CommentaryType', $commentary);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commentary_edit', array('id' => $commentary->getId()));
        }

        return $this->render('commentary/edit.html.twig', array(
            'commentary' => $commentary,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a commentary entity.
     *
     * @Route("/{id}", name="commentary_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Commentary $commentary)
    {
        $form = $this->createDeleteForm($commentary);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commentary);
            $em->flush($commentary);
        }

        return $this->redirectToRoute('commentary_index');
    }

    /**
     * Creates a form to delete a commentary entity.
     *
     * @param Commentary $commentary The commentary entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Commentary $commentary)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('commentary_delete', array('id' => $commentary->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
