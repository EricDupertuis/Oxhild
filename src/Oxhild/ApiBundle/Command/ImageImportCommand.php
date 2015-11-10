<?php

namespace Oxhild\ApiBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Doctrine\ORM\EntityManager;

/**
 * Class ImageImportCommand
 * @package Oxhild\ApiBundle\Command
 */
class ImageImportCommand extends ContainerAwareCommand
{

    /**
     * Entity Manager
     *
     * @var EntityManager $em
     */
    protected $em;

    /**
     * Configure command line options
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('mtg:import:images')
            ->setDescription('Import card images');
    }

    /**
     * Execute mtg:import:images
     *
     * @param InputInterface  $input  Command line input
     * @param OutputInterface $output Command line output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->em = $this->getContainer()->get("doctrine.orm.default_entity_manager");
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

        $availableDomains = ['mtgcorporation', 'starcitygames', 'gatherer'];

        $isPinged = false;
    }
}
