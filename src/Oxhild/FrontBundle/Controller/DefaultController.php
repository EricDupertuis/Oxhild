<?php

namespace Oxhild\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OxhildFrontBundle:Default:index.html.twig', array('name' => $name));
    }
}
