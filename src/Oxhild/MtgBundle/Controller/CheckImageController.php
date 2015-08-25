<?php

namespace Oxhild\MtgBundle\Controller;

use Oxhild\MtgBundle\Entity\Card;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class CheckImageController extends Controller
{
    public function checkImageAction($multiverse)
    {
        $fs = new Filesystem();
        if ($fs->exists("/scans/".$multiverse.".jpg")) {
            return $this->render(
                "OxhildMtgBundle:Card:scanImage.html.twig",
                [
                    'id' => $multiverse
                ]
            );
        } else {
            return $this->render(
                "OxhildMtgBundle:Card:scanImage.html.twig",
                [
                    'id' => $multiverse
                ]
            );
        }
    }
}