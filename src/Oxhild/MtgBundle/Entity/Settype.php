<?php

namespace Oxhild\MtgBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="set_types")
 */
class Settype
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @ORM\OneToMany(targetEntity="Set", mappedBy="type")
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Set", mappedBy="type")
     */
    protected $sets;

    public function __construct()
    {
        $this->sets = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getSets()
    {
        return $this->sets;
    }

    /**
     * @param mixed $sets
     */
    public function setSets($sets)
    {
        $this->sets = $sets;
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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Settype
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
