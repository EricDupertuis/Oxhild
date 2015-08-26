<?php
namespace Oxhild\MtgBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Color entity
 *
 * @package Oxhild\MtgBundle\Entity
 *
 * @author Eric Dupertuis <dupertuis.eric@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="colors")
 */
class Color
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
    protected $color;

    /**
     * @ORM\ManyToMany(targetEntity="Card", mappedBy="colors")
     */
    protected $cards;

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
     * Set color
     *
     * @param string $color
     * @return Color
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }
}
