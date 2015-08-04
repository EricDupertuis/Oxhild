<?php

namespace Oxhild\MtgBundle\Controller;

use Oxhild\MtgBundle\Form\SearchCardForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Oxhild\MtgBundle\Form\AddCardForm;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OxhildMtgBundle:Default:base.html.twig');
    }

    public function sidebarAction(){
        $form = $this->container->get('form.factory')->create(new SearchCardForm());

        if ($form->isValid()) {

        }

        return $this->render('OxhildMtgBundle:Components:usersidebar.html.twig', array('form' => $form->createView()));
    }
}
