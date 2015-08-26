<?php
namespace Oxhild\MtgBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Type entity
 *
 * @package Oxhild\MtgBundle\Entity
 *
 * @author Eric Dupertuis <dupertuis.eric@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="types")
 */
class Type
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
     * @ORM\ManyToMany(targetEntity="Card", mappedBy="types")
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
     * Set name
     *
     * @param string $name
     * @return Type
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
}
