<?php
namespace Oxhild\MtgBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
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


    protected $colors;
    /**
     * @ORM\Column(type="text")
     */
    protected $type;

    protected $supertypes;

    protected $types;

    protected $subtypes;

    /**
     * @ORM\Column(type="string")
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
     * @ORM\Column(type="string")
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
