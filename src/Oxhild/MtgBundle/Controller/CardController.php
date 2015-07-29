<?php

namespace Oxhild\MtgBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CardController extends Controller
{
    public function showAction($id)
    {
        $card = $this->getDoctrine()
            ->getRepository('OxhildMtgBundle:Card')
            ->findOneBy($id);

        dump($card);

        if (!$card) {
            throw $this->createNotFoundException(
                'No cards found with the id : '.$id
            );
        }

        return $this->render('OxhildMtgBundle:Card:show.html.twig', array( 'card' => $card ));
    }
}