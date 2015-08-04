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
}
