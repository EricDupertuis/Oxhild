<?php

namespace Oxhild\MtgBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oxhild\MtgBundle\Form\NewBinderForm;
use Oxhild\MtgBundle\Entity\Binder;

class BinderController extends Controller
{

    public function newAction()
    {
        $form = $this->container->get('form.factory')->create(new NewBinderForm());

        if ($form->isValid()) {
            $binder = new Binder();
        }

        return $this->render('OxhildMtgBundle:Binder:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

}