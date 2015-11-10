<?php

namespace Oxhild\ApiBundle\Controller;

use Oxhild\ApiBundle\Form\SearchCardForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Oxhild\ApiBundle\Form\AddCardForm;

/**
 * Class DefaultController
 *
 * @package Oxhild\ApiBundle\Controller
 *
 * @author Eric Dupertuis <dupertuis.eric@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * DefaultController class
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('OxhildApiBundle:Default:base.html.twig');
    }
}
