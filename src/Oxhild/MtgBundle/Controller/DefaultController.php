<?php

namespace Oxhild\MtgBundle\Controller;

use Oxhild\MtgBundle\Form\SearchCardForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Oxhild\MtgBundle\Form\AddCardForm;

/**
 * Class DefaultController
 *
 * @package Oxhild\MtgBundle\Controller
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
        return $this->render('OxhildMtgBundle:Default:base.html.twig');
    }
}
