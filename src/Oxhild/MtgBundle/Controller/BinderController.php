<?php

namespace Oxhild\MtgBundle\Controller;

use Oxhild\MtgBundle\Entity\BinderCard;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oxhild\MtgBundle\Form\NewBinderForm;
use Oxhild\MtgBundle\Entity\Binder;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BinderController
 *
 * @package Oxhild\MtgBundle\Controller
 *
 * @author Eric Dupertuis <dupertuis.eric@gmail.com>
 */
class BinderController extends Controller
{
    /**
     * List all binders by users
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $user = $this->getUser();
        $binders = $this->getDoctrine()
            ->getRepository('OxhildMtgBundle:Binder')
            ->findBy(
                ['user' => $user->getId()]
            );

        foreach ($binders as $binder) {
            $associations = $this->getDoctrine()
                ->getManager()
                ->getRepository('OxhildMtgBundle:BinderCard')
                ->findBy(['binder' => $binder]);
        }

        return $this->render(
            'OxhildMtgBundle:Binder:list.html.twig',
            [
                'binders' => $binders
            ]
        );
    }

    /**
     * New binder form
     *
     * @param Request $request HttpFoundation\Request
     *
     * @return bool|\Symfony\Component\HttpFoundation\Response
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(new NewBinderForm());

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $binder = new Binder();
            $binder->setName($data['name'])
                ->setDescription($data['description']);

            if ($data['private'] == true) {
                $binder->setPrivate(1);
            } elseif ($data['private'] == false) {
                $binder->setPrivate(0);
            } else {
                return false;
            }

            $binder->setAddedDate(new \DateTime("now"))
                ->setUpdatedDate(new \DateTime("now"));

            $user = $this->getUser();
            $binder->setUser($user);
            $em->persist($binder);
            $em->flush();
        }

        return $this->render(
            'OxhildMtgBundle:Binder:new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Retrieve all cards for a specific binder
     *
     * @param Binder $binder Binder Entity
     *
     * @return array|\Oxhild\MtgBundle\Entity\BinderCard[]
     */
    protected function retrieveCards($binder)
    {
        $em = $this->getDoctrine()->getManager();
        $binderCards = $em->getRepository('OxhildMtgBundle:BinderCard')
            ->findBy(
                ['binder' => $binder]
            );
        return $binderCards;
    }

    /**
     * Render view for a binder page
     *
     * @param int $id Binder id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($id)
    {
        $cards = $this->getDoctrine()
            ->getRepository('OxhildMtgBundle:BinderCard')
            ->getCardsByBinder($id);

        return $this->render(
            'OxhildMtgBundle:Binder:details.html.twig',
            ['cards' => $cards]
        );
    }
}