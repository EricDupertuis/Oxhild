<?php

namespace Oxhild\ImportBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Doctrine\ORM\EntityManager;
use Oxhild\MtgBundle\Entity\Card;

class ImportCommand extends ContainerAwareCommand
{

    /** @var  EntityManager $em */
    protected $em;

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
        $download = file_get_contents('http://mtgjson.com/json/AllSets.json');

        if ($download === false) {
            $output->writeln('<error>Oups, file not find. Check your internet connection</error>');
            die;
        } else {
            $data = json_decode($download);
            file_put_contents('arraycards.txt', print_r($data, true));
        }

        //foreach ($data as $set) {
            // Import set first



       // }
    }
}
