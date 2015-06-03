<?php
namespace Oxhild\MtgBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\OneToMany(targetEntity="Card", mappedBy="set")
     */
    protected $cards;

    /**
     * @ORM\Column(type="string", length=10)
     */
    protected $code;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $gathererCode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    protected $magicCardsInfoCode;

    /**
     * @var \DateTime
     * @ORM\Column(type="date", nullable=false)
     */
    protected $releaseDate;
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $borders;
    /**
     * @ORM\ManyToOne(targetEntity="Settype", inversedBy="sets")
     */
    protected $type;

    function __construct()
    {
        $this->cards = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     * @param mixed $cards
     */
    public function setCards($cards)
    {
        $this->cards = $cards;
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
     * @return Set
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Get gathererCode
     *
     * @return string
     */
    public function getGathererCode()
    {
        return $this->gathererCode;
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
     * Get magicCardsInfoCode
     *
     * @return string
     */
    public function getMagicCardsInfoCode()
    {
        return $this->magicCardsInfoCode;
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
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
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
     * Get borders
     *
     * @return string
     */
    public function getBorders()
    {
        return $this->borders;
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
     * Get type
     *
     * @return \Oxhild\MtgBundle\Entity\Settype
     */
    public function getType()
    {
        return $this->type;
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
}
