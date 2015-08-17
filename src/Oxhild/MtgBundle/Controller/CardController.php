<?php

namespace Oxhild\MtgBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Doctrine\ORM\EntityManager;
use \Doctrine\ORM\Query;
use Oxhild\MtgBundle\Form\SearchCardForm;
use Oxhild\MtgBundle\Entity\Binder;
use Oxhild\MtgBundle\Form\AddCardForm;
use Symfony\Component\HttpFoundation\Request;

class CardController extends Controller
{
    /** @var  EntityManager $em */
    protected $em;

    public function showAction(Request $request, $id)
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

        $form = $this->createForm(new AddCardForm(), new binder(), ['attr' => [
                'user' => $userId
            ]
        ]);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            dump($data);

            $binder = $this->getDoctrine()
                ->getRepository('OxhildMtgBundle:Binder')
                ->findOneBy(['name' => $data->getName()->getName()]);

            $binder->addCard($card);
            $em = $this->getDoctrine()->getManager();
            $em->persist($binder);
            $em->flush();

        }

        return $this->render('OxhildMtgBundle:Card:show.html.twig', [
            'card' => $card,
            'rarity' => $card->getRarity(),
            'artist' => $card->getArtist(),
            'layout' => $card->getLayout(),
            'set' => $card->getSet(),
            'form' => $form->createView()
        ]);
    }

    public function searchAction(Request $request)
    {

    }
}