<?php

namespace Oxhild\MtgBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('OxhildMtgBundle:Default:index.html.twig');
    }
}
