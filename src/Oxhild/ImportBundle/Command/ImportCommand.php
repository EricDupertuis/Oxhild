<?php

namespace Oxhild\ImportBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Doctrine\ORM\EntityManager;
use Oxhild\MtgBundle\Entity\Card;
use Oxhild\MtgBundle\Entity\Set;

class ImportCommand extends ContainerAwareCommand
{

    /** @var  EntityManager $em */
    protected $em;

    protected $isDebug = true; // put false if you have active internet connection

    protected function configure()
    {
        $this
            ->setName('mtg:import:all')
            ->setDescription('Import data from AllSets.json')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->em = $this->getContainer()->get("doctrine.orm.default_entity_manager");

        $output->writeln('<info>Downloading json file</info>');

        if ($this->isDebug === false) {
            $download = file_get_contents('http://mtgjson.com/json/AllSets.json');

            if ($download === false) {
                $output->writeln('<error>Oups, file not find. Check your internet connection</error>');
                die;
            } else {
                $output->writeln('<info>Download successful</info>');
                $data = json_decode($download, true);
                file_put_contents('cachecards.cache', serialize($data));
            }
        } else {
            $download = unserialize(file_get_contents("cachecards.cache"));

            if ($download === false) {
                $output->writeln('<error>Oups, Something went wrong. Debug mode is active</error>');
                die;
            } else {
                $output->writeln('<info>Download successful</info>');
                $data = $download;
            }
        }

        foreach ($data as $content) {
            // Import set first

            $check = $this->$em->getRepository('OxhildMtgBundle:Set');
            $exists = $check->findBy(
                array('name' => $content['name'])
            );

            if (!$exists) {
                $set = new Set();

                $set->setName($content['name'])
                    ->setCode($content['code'])
                    ->setGathererCode($content['gathererCode'])
                    ->setMagicCardsInfoCode($content['magicCardsInfoCode]'])
                    ->setBorders($content['border'])
                    ->setType($content['type']);

                $this->$em->persist($set);
                $this->$em->flush();

                foreach ($content['cards'] as $cardData) {
                    $card = new Card();

                    $card->setName($cardData['name'])
                        ->setType($cardData['type'];
                }
            }
        }
    }
}
