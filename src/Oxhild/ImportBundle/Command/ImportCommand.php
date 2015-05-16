<?php

namespace Oxhild\ImportBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Doctrine\ORM\EntityManager;
use Oxhild\MtgBundle\Entity\Card;
use Oxhild\MtgBundle\Entity\Set;
use Oxhild\MtgBundle\Entity\Settype;
use Oxhild\MtgBundle\Entity\Layout;
use Oxhild\MtgBundle\Entity\Type;
use \DateTime;

class ImportCommand extends ContainerAwareCommand
{

    /** @var  EntityManager $em */
    protected $em;

    protected $isDebug = true; // put false if you have active internet connection, allows offline dev

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
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

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

            $exist = $this->em->getRepository('OxhildMtgBundle:Set')->findBy(
                array('name' => $content['name'])
            );

            if ($exist == null) {

                $output->writeln('<info>Set not found, adding to database</info>');

                $set = new Set();
                $settype = new Settype();

                $type = $this->em->getRepository('OxhildMtgBundle:Settype')->findBy(
                    array('name' => $content['type'])
                );

                if ($type == null) {
                    $output->writeln('<info>Set type not found, adding to database</info>');

                    $settype->setName($content['type']);
                    $this->em->persist($settype);
                    $this->em->flush();

                    $type = $this->em->getRepository('OxhildMtgBundle:Settype')->findOneBy(["name" => $content['type']]);
                } else {
                    $output->writeln('<info>Set type exists, skipping</info>');
                    $type = $this->em->getRepository('OxhildMtgBundle:Settype')->findOneBy(["name" => $content['type']]);
                }

                $date = new DateTime($content['releaseDate']);

                $set->setName($content['name'])
                    ->setCode($content['code'])
                    ->setGathererCode($content['gathererCode'])
                    ->setMagicCardsInfoCode($content['magicCardsInfoCode'])
                    ->setReleaseDate($date)
                    ->setBorders($content['border'])
                    ->setType($type);

                $this->em->persist($set);
                $this->em->flush();

                foreach ($content['cards'] as $cardData) {
                    $card = new Card();

                    // Layout

                    $layout = $this->em->getRepository('OxhildMtgBundle:Layout')->findOneBy(["name" => $cardData['layout']]);

                    if ($layout === null) {
                        $newLayout = new Layout();
                        $newLayout->setName($cardData['layout']);
                        $this->em->persist($newLayout);
                        $this->em->flush();

                        $layout = $this->em->getRepository('OxhildMtgBundle:Layout')->findOneBy(["name" => $cardData['layout']]);

                    } else {
                        $layout = $this->em->getRepository('OxhildMtgBundle:Layout')->findOneBy(["name" => $cardData['layout']]);
                    }

                    // End Layout

                    // Type

                    foreach($cardData['types'] as $cardType) {
                        $searchType = $this->em->getRepository('OxhildMtgBundle:Type')->findOneBy(['name' => $cardType]);

                        if ($searchType == null) {
                            $newType = new Type();
                            $newType->setName($cardType);
                            $this->em->persist($newType);
                            $this->em->flush();
                        }
                    }

                    // End Type

                    $card->addLayout($layout)
                        ->setType($cardData['type'])
                        ->addColor($cardData['colors'])
                        ->setMultiverseid($cardData['multiverseid'])
                        ->setName($cardData['name'])
                        ->addSubtype($cardData['subtypes'])
                        ->setCmc($cardData['cmc'])
                        ->setRarity($cardData['rarity'])
                        ->setArtist($cardData['artist'])
                        ->setPower($cardData['power'])
                        ->setToughness($cardData['toughness'])
                        ->setManaCost($cardData['manaCost'])
                        ->setText($cardData['text'])
                        ->setFlavor($cardData['flavor'])
                        ->setImageName($cardData['imageName']);

                    $this->em->persist($card);
                    $this->em->flush();
                }
            }
        }
    }
}
