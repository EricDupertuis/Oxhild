<?php

namespace Oxhild\MtgBundle\Controller;

use Oxhild\MtgBundle\Entity\BinderCard;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Doctrine\ORM\EntityManager;
use \Doctrine\ORM\Query;
use Oxhild\MtgBundle\Entity\Binder;
use Oxhild\MtgBundle\Form\AddCardForm;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CardController
 *
 * @package Oxhild\MtgBundle\Controller
 *
 * @author Eric Dupertuis <dupertuis.eric@gmail.com>
 */
class CardController extends Controller
{
    /**
     * @var EntityManager $em Doctrine entity manager
     */
    protected $em;

    /**
     * Show one card details
     *
     * @param Request $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
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
            $em = $this->getDoctrine()->getManager();

            $binder = $em->getRepository('OxhildMtgBundle:Binder')
                ->findOneBy(['name' => $data->getName()->getName()]);

            $binderCard = $em->getRepository('OxhildMtgBundle:BinderCard')
                ->findOneBy(
                    [
                        'binder' => $binder->getId(),
                        'card' => $card->getId()
                    ]
                );

            if ($binderCard == null) {
                $binderCard = new BinderCard();
                $binderCard->setCard($card);
                $binderCard->setBinder($binder);
                $binderCard->setCount(1);
            } else {
                $binderCard->setCard($card);
                $binderCard->setBinder($binder);
                $binderCard->addCount();
            }

            $em->persist($binderCard);
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

    /**
     * Search for cards by name
     *
     * @param Request $request
     */
    public function searchAction(Request $request)
    {

    }
}