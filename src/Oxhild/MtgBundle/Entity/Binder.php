<?php

namespace Oxhild\MtgBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="binders")
 */
class Binder
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="Card", cascade={"persist"})
     **/
    protected $cards;

    /**
     * @ORM\ManyToOne(targetEntity="Oxhild\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $user;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    protected $private;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $added_date;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    protected $updated_date;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cards = new ArrayCollection();
        $this->updated_date = new \DateTime();
        $this->added_date = new \DateTime();
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Binder
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Binder
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set private
     *
     * @param boolean $private
     * @return Binder
     */
    public function setPrivate($private)
    {
        $this->private = $private;

        return $this;
    }

    /**
     * Get private
     *
     * @return boolean 
     */
    public function getPrivate()
    {
        return $this->private;
    }

    /**
     * Set added_date
     *
     * @param \DateTime $addedDate
     * @return Binder
     */
    public function setAddedDate($addedDate)
    {
        $this->added_date = $addedDate;

        return $this;
    }

    /**
     * Get added_date
     *
     * @return \DateTime 
     */
    public function getAddedDate()
    {
        return $this->added_date;
    }

    /**
     * Set updated_date
     *
     * @param \DateTime $updatedDate
     * @return Binder
     */
    public function setUpdatedDate($updatedDate)
    {
        $this->updated_date = $updatedDate;

        return $this;
    }

    /**
     * Get updated_date
     *
     * @return \DateTime 
     */
    public function getUpdatedDate()
    {
        return $this->updated_date;
    }

    /**
     * Add cards
     *
     * @param \Oxhild\MtgBundle\Entity\Card $cards
     * @return Binder
     */
    public function addCard(\Oxhild\MtgBundle\Entity\Card $cards)
    {
        $this->cards[] = $cards;

        return $this;
    }

    /**
     * Remove cards
     *
     * @param \Oxhild\MtgBundle\Entity\Card $cards
     */
    public function removeCard(\Oxhild\MtgBundle\Entity\Card $cards)
    {
        $this->cards->removeElement($cards);
    }

    /**
     * Get cards
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * Set user
     *
     * @param \Oxhild\UserBundle\Entity\User $user
     * @return Binder
     */
    public function setUser(\Oxhild\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Oxhild\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
