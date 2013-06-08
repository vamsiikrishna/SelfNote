<?php

namespace Vamsi\SelfNoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('VamsiSelfNoteBundle:Lists')->findAll();
        return $this->render('VamsiSelfNoteBundle:Default:index.html.twig',array('entities'=>$entities));
    }
}
