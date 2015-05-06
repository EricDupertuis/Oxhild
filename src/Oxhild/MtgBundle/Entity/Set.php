<?php
namespace Oxhild\MtgBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="sets")
 */
class Set
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $code;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $gathererCode;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $magicCardsInfoCode;

    /**
     * @ORM\Column(type="date")
     */
    protected $releaseDate;

    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $borders;

    /**
     * @ORM\ManyToOne(targetEntity="Oxhild\MtgBundle\Entity\Settype")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     */
    protected $type;

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
     * @return Set
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
     * Set code
     *
     * @param string $code
     * @return Set
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set gathererCode
     *
     * @param string $gathererCode
     * @return Set
     */
    public function setGathererCode($gathererCode)
    {
        $this->gathererCode = $gathererCode;

        return $this;
    }

    /**
     * Get gathererCode
     *
     * @return string 
     */
    public function getGathererCode()
    {
        return $this->gathererCode;
    }

    /**
     * Set magicCardsInfoCode
     *
     * @param string $magicCardsInfoCode
     * @return Set
     */
    public function setMagicCardsInfoCode($magicCardsInfoCode)
    {
        $this->magicCardsInfoCode = $magicCardsInfoCode;

        return $this;
    }

    /**
     * Get magicCardsInfoCode
     *
     * @return string 
     */
    public function getMagicCardsInfoCode()
    {
        return $this->magicCardsInfoCode;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     * @return Set
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime 
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set borders
     *
     * @param string $borders
     * @return Set
     */
    public function setBorders($borders)
    {
        $this->borders = $borders;

        return $this;
    }

    /**
     * Get borders
     *
     * @return string 
     */
    public function getBorders()
    {
        return $this->borders;
    }

    /**
     * Set type
     *
     * @param \Oxhild\MtgBundle\Entity\Settype $type
     * @return Set
     */
    public function setType(\Oxhild\MtgBundle\Entity\Settype $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Oxhild\MtgBundle\Entity\Settype 
     */
    public function getType()
    {
        return $this->type;
    }
}