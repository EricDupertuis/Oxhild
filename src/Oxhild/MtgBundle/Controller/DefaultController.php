<?php

namespace Oxhild\MtgBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Oxhild\MtgBundle\Entity\Card;
use Oxhild\MtgBundle\Entity\Type;
use Oxhild\MtgBundle\Entity\Supertype;
use Oxhild\MtgBundle\Entity\Layout;
use Oxhild\MtgBundle\Entity\Subtype;
use Oxhild\MtgBundle\Entity\Color;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $card = new Card();
        $form = $this->createFormBuilder($card)
            ->add('name', 'text')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            return $this->redirect($this->generateUrl('search_card'));
        }

        return $this->render('OxhildMtgBundle:Default:base.html.twig', array('form' => $form->createView(),));
    }

    public function searchAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $em->getRepository('OxhildMtgBundle:Card')->findBy(['name' => $name]);

        return $this->render('OxhildMtgBundle:Default:base.html.twig', array('form' => 'search success'));
    }
}
