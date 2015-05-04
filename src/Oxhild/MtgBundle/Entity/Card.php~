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
     * @ORM\Column(type="text")
     */
    protected $text;

    /**
     * @ORM\Column(type="text")
     */
    protected $flavor;

    /**
     * @ORM\ManyToOne(targetEntity="Oxhild\MtgBundle\Entity\Artist")
     * @ORM\JoinColumn(name="artist_id", referencedColumnName="id")
     */
    protected $artist;

    /**
     * @ORM\Column(type="integer")
     */
    protected $number;

    /**
     * @ORM\Column(type="string")
     */
    protected $power;

    /**
     * @ORM\Column(type="string")
     */
    protected $toughness;

    /**
     * @ORM\ManyToMany(targetEntity="Layout", inversedBy="cards")
     * @ORM\JoinTable(name="layouts_cards")
     */
    protected $layout;

    /**
     * @ORM\Column(type="integer")
     */
    protected $multiverseid;

    /**
     * @ORM\Column(type="string")
     */
    protected $image_name;
}
