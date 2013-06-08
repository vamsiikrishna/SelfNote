<?php

namespace Vamsi\SelfNoteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Vamsi\SelfNoteBundle\Entity\Lists;
use Vamsi\SelfNoteBundle\Form\ListsType;

use Vamsi\SelfNoteBundle\Entity\Note;

/**
 * Lists controller.
 *
 */
class ListsController extends Controller
{
    /**
     * Lists all Lists entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('VamsiSelfNoteBundle:Lists')->findAll();

        return $this->render('VamsiSelfNoteBundle:Lists:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Lists entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Lists();
        $form = $this->createForm(new ListsType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lists_show', array('id' => $entity->getId())));
        }

        return $this->render('VamsiSelfNoteBundle:Lists:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Lists entity.
     *
     */
    public function newAction()
    {
        $entity = new Lists();
        $form   = $this->createForm(new ListsType(), $entity);

        return $this->render('VamsiSelfNoteBundle:Lists:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Lists entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();



        $entity = $em->getRepository('VamsiSelfNoteBundle:Lists')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lists entity.');
        }

        $notes = $em->getRepository('VamsiSelfNoteBundle:Note')->findByLists($entity);


        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VamsiSelfNoteBundle:Lists:show.html.twig', array(
            'entity'      => $entity,
            'notes'       => $notes,
            'delete_form' => $deleteForm->createView(),        ));




    }

    /**
     * Displays a form to edit an existing Lists entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VamsiSelfNoteBundle:Lists')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lists entity.');
        }

        $editForm = $this->createForm(new ListsType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('VamsiSelfNoteBundle:Lists:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Lists entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('VamsiSelfNoteBundle:Lists')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Lists entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ListsType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('lists_edit', array('id' => $id)));
        }

        return $this->render('VamsiSelfNoteBundle:Lists:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Lists entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('VamsiSelfNoteBundle:Lists')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Lists entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vamsi_self_note_homepage'));
    }

    /**
     * Creates a form to delete a Lists entity by id.
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
