<?php

namespace Vamsi\SelfNoteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Vamsi\SelfNoteBundle\Entity\Note;
use Vamsi\SelfNoteBundle\Form\NoteType;

/**
 * Note controller.
 *
 */
class NoteController extends Controller
{
    /**
     * Lists all Note entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VamsiSelfNoteBundle:Note')->findAll();

        return $this->render('VamsiSelfNoteBundle:Note:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Note entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Note();
        $form = $this->createForm(new NoteType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('note_show', array('id' => $entity->getId())));
        }

        return $this->render('VamsiSelfNoteBundle:Note:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Note entity.
     *
     */
    public function newAction()
    {
        $entity = new Note();
        $form   = $this->createForm(new NoteType(), $entity);

        return $this->render('VamsiSelfNoteBundle:Note:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Note entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VamsiSelfNoteBundle:Note')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Note entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VamsiSelfNoteBundle:Note:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Note entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VamsiSelfNoteBundle:Note')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Note entity.');
        }

        $editForm = $this->createForm(new NoteType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VamsiSelfNoteBundle:Note:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Note entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VamsiSelfNoteBundle:Note')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Note entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new NoteType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('note_edit', array('id' => $id)));
        }

        return $this->render('VamsiSelfNoteBundle:Note:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Note entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VamsiSelfNoteBundle:Note')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Note entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('note'));
    }

    /**
     * Creates a form to delete a Note entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
