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
    public function indexAction()
    {
        return $this->render('OxhildMtgBundle:Default:base.html.twig');
    }

    public function searchAction($name)
    {
        $em = $this->getDoctrine()->getManager();
        $cards = $em->getRepository('OxhildMtgBundle:Card')->createQueryBuilder('c')
            ->where('c.name LIKE :name')
            ->setParameter('name', '%'.$name.'%')
            ->getQuery()
            ->getResult();

        return $this->render('OxhildMtgBundle:Default:base.html.twig', array('cards' => $cards));
    }
}
