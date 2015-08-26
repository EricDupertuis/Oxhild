<?php

namespace Oxhild\MtgBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * Image entity
 *
 * @package Oxhild\MtgBundle\Entity
 *
 * @author Eric Dupertuis <dupertuis.eric@gmail.com>
 *
 * @ORM\Entity
 * @ORM\Table(name="Scans")
 */
class ImageScan
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $extension;

    /**
     * @ORM\OneToMany(targetEntity="Oxhild\MtgBundle\Entity\Card", mappedBy="scan")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $cards;
}