<?php

namespace Oxhild\MtgBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Doctrine\ORM\EntityManager;

class ImportCommand extends ContainerAwareCommand
{

    /** @var  EntityManager $em */
    protected $em;

    protected $isDebug = true; // put false if you have active internet connection, allows offline dev

    protected function configure()
    {
        $this
            ->setName('mtg:import:cards')
            ->setDescription('Import card images')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->em = $this->getContainer()->get("doctrine.orm.default_entity_manager");
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);


    }
}
