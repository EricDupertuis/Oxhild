<?php

namespace Oxhild\MtgBundle\Controller;

use Oxhild\MtgBundle\Entity\Card;
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
     * @param int $multiverse Multiverse Id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function checkImageAction($multiverse)
    {

    }
}