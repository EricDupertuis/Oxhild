<?php

namespace Oxhild\MtgBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class BinderCard
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Oxhild\MtgBundle\Entity\Binder")
     */
    private $binder;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Oxhild\MtgBundle\Entity\Card")
     */
    private $card;

    /**
     * @return mixed
     */
    public function getBinder()
    {
        return $this->binder;
    }

    /**
     * @param mixed $binder
     */
    public function setBinder($binder)
    {
        $this->binder = $binder;
    }

    /**
     * @return mixed
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * @param mixed $card
     */
    public function setCard($card)
    {
        $this->card = $card;
    }
}