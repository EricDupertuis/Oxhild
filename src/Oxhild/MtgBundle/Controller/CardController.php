<?php

namespace Oxhild\MtgBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oxhild\MtgBundle\Entity\Set;
use Oxhild\MtgBundle\Entity\Binder;
use Oxhild\MtgBundle\Form\AddCardForm;

class CardController extends Controller
{
    public function showAction($id)
    {
        $card = $this->getDoctrine()
            ->getRepository('OxhildMtgBundle:Card')
            ->findOneBy(['id' => $id]);

        if (!$card) {
            throw $this->createNotFoundException(
                'No cards found with the id : '.$id
            );
        }

        $userId = $this->getUser()->getId();

        dump($userId);

        $form = $this->createForm(new AddCardForm(), new binder(), ['attr' => [
                'user' => $userId
            ]
        ]);

        return $this->render('OxhildMtgBundle:Card:show.html.twig', [
            'card' => $card,
            'rarity' => $card->getRarity(),
            'artist' => $card->getArtist(),
            'layout' => $card->getLayout(),
            'set' => $card->getSet(),
            'form' => $form->createView()
        ]);
    }
}