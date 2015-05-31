<?php
namespace Oxhild\MtgBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="cards")
 */
class Card
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(type="string")
     */
    protected $mana_cost;

    /**
     * @ORM\Column(type="integer")
     */
    protected $cmc;

    /**
     * @ORM\ManyToMany(targetEntity="Color", inversedBy="cards")
     * @ORM\JoinTable(name="colors_cards")
     */
    protected $colors;

    /**
     * @ORM\Column(type="string")
     */
    protected $type;

    /**
     * @ORM\ManyToMany(targetEntity="Supertype", inversedBy="cards")
     * @ORM\JoinTable(name="supertypes_cards")
     */
    protected $supertypes;

    /**
     * @ORM\ManyToMany(targetEntity="Type", inversedBy="cards")
     * @ORM\JoinTable(name="types_cards")
     */
    protected $types;

    /**
     * @ORM\ManyToMany(targetEntity="Subtype", inversedBy="cards")
     * @ORM\JoinTable(name="subtypes_cards")
     */
    protected $subtypes;

    /**
     * @ORM\ManyToOne(targetEntity="Oxhild\MtgBundle\Entity\Rarity")
     * @ORM\JoinColumn(name="rarity_id", referencedColumnName="id")
     */
    protected $rarity;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $text;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $flavor;

    /**
     * @ORM\ManyToOne(targetEntity="Oxhild\MtgBundle\Entity\Artist")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     */
    protected $artist;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $number;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $power;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $toughness;

    /**
     * @ORM\ManyToMany(targetEntity="Layout", inversedBy="cards")
     * @ORM\JoinTable(name="layouts_cards")
     */
    protected $layout;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $multiverseid;

    /**
     * @ORM\Column(type="string")
     */
    protected $image_name;

    /**
     * @ORM\ManyToOne(targetEntity="Oxhild\MtgBundle\Entity\Set")
     * @ORM\JoinColumn(name="set_id", referencedColumnName="id")
     */
    protected $set;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->colors = new \Doctrine\Common\Collections\ArrayCollection();
        $this->supertypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->types = new \Doctrine\Common\Collections\ArrayCollection();
        $this->subtypes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->layout = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Card
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
     * Set mana_cost
     *
     * @param string $manaCost
     * @return Card
     */
    public function setManaCost($manaCost)
    {
        $this->mana_cost = $manaCost;

        return $this;
    }

    /**
     * Get mana_cost
     *
     * @return string 
     */
    public function getManaCost()
    {
        return $this->mana_cost;
    }

    /**
     * Set cmc
     *
     * @param integer $cmc
     * @return Card
     */
    public function setCmc($cmc)
    {
        $this->cmc = $cmc;

        return $this;
    }

    /**
     * Get cmc
     *
     * @return integer 
     */
    public function getCmc()
    {
        return $this->cmc;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Card
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Card
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set flavor
     *
     * @param string $flavor
     * @return Card
     */
    public function setFlavor($flavor)
    {
        $this->flavor = $flavor;

        return $this;
    }

    /**
     * Get flavor
     *
     * @return string 
     */
    public function getFlavor()
    {
        return $this->flavor;
    }

    /**
     * Set number
     *
     * @param integer $number
     * @return Card
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer 
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set power
     *
     * @param string $power
     * @return Card
     */
    public function setPower($power)
    {
        $this->power = $power;

        return $this;
    }

    /**
     * Get power
     *
     * @return string 
     */
    public function getPower()
    {
        return $this->power;
    }

    /**
     * Set toughness
     *
     * @param string $toughness
     * @return Card
     */
    public function setToughness($toughness)
    {
        $this->toughness = $toughness;

        return $this;
    }

    /**
     * Get toughness
     *
     * @return string 
     */
    public function getToughness()
    {
        return $this->toughness;
    }

    /**
     * Set multiverseid
     *
     * @param integer $multiverseid
     * @return Card
     */
    public function setMultiverseid($multiverseid)
    {
        $this->multiverseid = $multiverseid;

        return $this;
    }

    /**
     * Get multiverseid
     *
     * @return integer 
     */
    public function getMultiverseid()
    {
        return $this->multiverseid;
    }

    /**
     * Set image_name
     *
     * @param string $imageName
     * @return Card
     */
    public function setImageName($imageName)
    {
        $this->image_name = $imageName;

        return $this;
    }

    /**
     * Get image_name
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->image_name;
    }

    /**
     * Add colors
     *
     * @param \Oxhild\MtgBundle\Entity\Color $colors
     * @return Card
     */
    public function addColor(\Oxhild\MtgBundle\Entity\Color $colors)
    {
        $this->colors[] = $colors;

        return $this;
    }

    /**
     * Remove colors
     *
     * @param \Oxhild\MtgBundle\Entity\Color $colors
     */
    public function removeColor(\Oxhild\MtgBundle\Entity\Color $colors)
    {
        $this->colors->removeElement($colors);
    }

    /**
     * Get colors
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * Add supertypes
     *
     * @param \Oxhild\MtgBundle\Entity\Supertype $supertypes
     * @return Card
     */
    public function addSupertype(\Oxhild\MtgBundle\Entity\Supertype $supertypes)
    {
        $this->supertypes[] = $supertypes;

        return $this;
    }

    /**
     * Remove supertypes
     *
     * @param \Oxhild\MtgBundle\Entity\Supertype $supertypes
     */
    public function removeSupertype(\Oxhild\MtgBundle\Entity\Supertype $supertypes)
    {
        $this->supertypes->removeElement($supertypes);
    }

    /**
     * Get supertypes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSupertypes()
    {
        return $this->supertypes;
    }

    /**
     * Add types
     *
     * @param \Oxhild\MtgBundle\Entity\Type $types
     * @return Card
     */
    public function addType(\Oxhild\MtgBundle\Entity\Type $types)
    {
        $this->types[] = $types;

        return $this;
    }

    /**
     * Remove types
     *
     * @param \Oxhild\MtgBundle\Entity\Type $types
     */
    public function removeType(\Oxhild\MtgBundle\Entity\Type $types)
    {
        $this->types->removeElement($types);
    }

    /**
     * Get types
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Add subtypes
     *
     * @param \Oxhild\MtgBundle\Entity\Subtype $subtypes
     * @return Card
     */
    public function addSubtype(\Oxhild\MtgBundle\Entity\Subtype $subtypes)
    {
        $this->subtypes[] = $subtypes;

        return $this;
    }

    /**
     * Remove subtypes
     *
     * @param \Oxhild\MtgBundle\Entity\Subtype $subtypes
     */
    public function removeSubtype(\Oxhild\MtgBundle\Entity\Subtype $subtypes)
    {
        $this->subtypes->removeElement($subtypes);
    }

    /**
     * Get subtypes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubtypes()
    {
        return $this->subtypes;
    }

    /**
     * Set rarity
     *
     * @param \Oxhild\MtgBundle\Entity\Rarity $rarity
     * @return Card
     */
    public function setRarity(\Oxhild\MtgBundle\Entity\Rarity $rarity = null)
    {
        $this->rarity = $rarity;

        return $this;
    }

    /**
     * Get rarity
     *
     * @return \Oxhild\MtgBundle\Entity\Rarity 
     */
    public function getRarity()
    {
        return $this->rarity;
    }

    /**
     * Set artist
     *
     * @param \Oxhild\MtgBundle\Entity\Artist $artist
     * @return Card
     */
    public function setArtist(\Oxhild\MtgBundle\Entity\Artist $artist = null)
    {
        $this->artist = $artist;

        return $this;
    }

    /**
     * Get artist
     *
     * @return \Oxhild\MtgBundle\Entity\Artist 
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * Add layout
     *
     * @param \Oxhild\MtgBundle\Entity\Layout $layout
     * @return Card
     */
    public function addLayout(\Oxhild\MtgBundle\Entity\Layout $layout)
    {
        $this->layout[] = $layout;

        return $this;
    }

    /**
     * Remove layout
     *
     * @param \Oxhild\MtgBundle\Entity\Layout $layout
     */
    public function removeLayout(\Oxhild\MtgBundle\Entity\Layout $layout)
    {
        $this->layout->removeElement($layout);
    }

    /**
     * Get layout
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Set set
     *
     * @param \Oxhild\MtgBundle\Entity\Set $set
     * @return Card
     */
    public function setSet(\Oxhild\MtgBundle\Entity\Set $set = null)
    {
        $this->set = $set;

        return $this;
    }

    /**
     * Get set
     *
     * @return \Oxhild\MtgBundle\Entity\Set 
     */
    public function getSet()
    {
        return $this->set;
    }
}
