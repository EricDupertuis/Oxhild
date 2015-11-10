<?php

namespace Oxhild\ApiBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Oxhild\ApiBundle\Entity\BinderCard;

/**
 * Class BinderCardRepository
 *
 * @package Oxhild\ApiBundle\Repository
 *
 * @author Eric Dupertuis <dupertuis.eric@gmail.com>
 */
class BinderCardRepository extends EntityRepository
{
    /**
     * Get one specific entity
     *
     * @param Card   $card   Card Entity
     * @param Binder $binder Binder Entity
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function getOneEntity($card, $binder)
    {
        $em = $this->getEntityManager();

        $card = $this->$em->getRepository('OxhildApiBundle:Card')
            ->find($card);
        $binder = $em->getRepository('OxhildApiBundle:Binder')
            ->find($binder);

        $compare = $em->getRepository('OxhildApiBundle:BinderCard')
            ->createQueryBuilder('r')
            ->select('r')
            ->where('r.binder = :binder')
            ->andWhere('r.card = :card')
            ->setParameter('card', $card)
            ->setParameter('binder', $binder)
            ->getQuery()
            ->getOneOrNullResult();

        return $compare;
    }

    /**
     * Get all cards of a specific binder
     *
     * @param int $id Binder id
     *
     * @return array|bool
     */
    public function getCardsByBinder($id)
    {
        $entities = $this->getEntityManager()
            ->getRepository('OxhildApiBundle:BinderCard')
            ->createQueryBuilder('q')
            ->select('q')
            ->where('q.binder = :binder')
            ->orderBy('q.card', 'ASC')
            ->setParameter('binder', $id)
            ->getQuery()
            ->getResult();

        if ($entities == null) {
            return false;
        }

        $cards = [];

        foreach ($entities as $entity) {
            $cards[] = $entity->getCard();
        }

        return $cards;
    }

    /**
     * Add a card to a binder
     *
     * Create a BinderCard entity if it doesn't exist, add a counter
     * to it if it already exists.
     *
     * @param Card   $card   Card entity
     * @param Binder $binder Binder entity
     *
     * @return bool
     */
    public function addCardToBinder($card, $binder)
    {
        $compare = $this->getOneEntity($card, $binder);
        $em = $this->getEntityManager();
        if ($compare == null) {
            $add = new BinderCard();
            $add->setCard($card);
            $add->setBinder($card);
            $em->persist($add);
            $em->flush();
        } else {
            $compare->addCount();
            $em->persist($compare);
            $em->flush();
        }

        return true;
    }

    /**
     * Remove a count to a card, if count falls down
     * to zero, remove entity from db
     *
     * @param Card   $card   Card Entity
     * @param Binder $binder Binder Entity
     *
     * @return bool
     */
    public function removeCardFromBinder($card, $binder)
    {
        $compare = $this->getOneEntity($card, $binder);

        if ($compare == null) {
            return false;
        } else {
            $em = $this->getEntityManager();
            $compare->removeCount();
            if ($compare->getCount() === 0) {
                $em->remove($compare);
            } else {
                $em->persist($compare);
            }
            $em->flush();
            return true;
        }
    }
}
