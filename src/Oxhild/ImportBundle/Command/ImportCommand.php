<?php

namespace Oxhild\ImportBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Oxhild\MtgBundle\Entity\Card;
use Oxhild\MtgBundle\Entity\Artist;
use Oxhild\MtgBundle\Entity\Color;
use Oxhild\MtgBundle\Entity\Layout;
use Oxhild\MtgBundle\Entity\Rarity;
use Oxhild\MtgBundle\Entity\Subtype;
use Oxhild\MtgBundle\Entity\Supertype;
use Oxhild\MtgBundle\Entity\type;
class ImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('import:all')
            ->setDescription('Import data from AllSets.json')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $jsonData = json_decode(file_get_contents('http://mtgjson.com/json/AllSets.json'));

        foreach($jsonData as $key => $value) {
            $card = new Card();
        }
    }
}