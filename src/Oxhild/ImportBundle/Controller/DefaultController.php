<?php

namespace Oxhild\ImportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OxhildImportBundle:Default:index.html.twig', array('name' => $name));
    }
}
