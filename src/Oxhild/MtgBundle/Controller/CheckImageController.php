<?php

namespace Oxhild\MtgBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

/**
 * Class CheckImageController
 *
 * @package Oxhild\MtgBundle\Controller
 *
 * @author Eric Dupertuis <dupertuis.eric@gmail.com>
 */
class CheckImageController extends Controller
{
    /**
     * Check if image is available, otherwise, scrape it
     *
     * @param Card $card Card Entity
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function checkImageAction($card)
    {
        $image = $this->getDoctrine()
            ->getManager()
            ->getRepository('OxhildMtgBundle:ImageScan')
            ->findOneBy('name' => $card->getName());

        $path = $image->getName().$image->getExtension();

        return $path
    }
}