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
            ->setName('mtg:import:all')
            ->setDescription('Import data from AllSets.json')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $data = json_decode(file_get_contents('http://mtgjson.com/json/AllCards.json'));

        foreach($data as $key => $value) {

            foreach($value as $c) {
                $card = new Card();

                $card->setName($c['name']);
                $card->setManaCost($c['name']);
                $card->setCmc($c['cmc']);

                $em = $this->getContainer()->get('doctrine')->getManager();

                $em->persist($card);
            }
        }
    }
}