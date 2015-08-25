<?php

namespace Oxhild\MtgBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\ProgressBar;
use Doctrine\ORM\EntityManager;
use Oxhild\MtgBundle\Entity\Artist;
use Oxhild\MtgBundle\Entity\Rarity;
use Oxhild\MtgBundle\Entity\Subtype;
use Oxhild\MtgBundle\Entity\Supertype;
use Oxhild\MtgBundle\Entity\Card;
use Oxhild\MtgBundle\Entity\Set;
use Oxhild\MtgBundle\Entity\Settype;
use Oxhild\MtgBundle\Entity\Layout;
use Oxhild\MtgBundle\Entity\Type;
use Oxhild\MtgBundle\Entity\Color as MtgColor;
use \DateTime;

/**
 * Class ImportCommand
 *
 * This scripts needs a good amount of RAM, do not run this on
 * a 28MB vhost as it won't work. The script itself doesn't need too
 * much ram but flushing does
 *
 * @package Oxhild\MtgBundle\Command
 *
 * @author Eric Dupertuis <dupertuis.eric@gmail.com>s
 */
class ImportCommand extends ContainerAwareCommand
{

    /**
     * Entity manager
     *
     * @var EntityManager $em
     */
    protected $em;

    protected $isDebug = true; // Allows offline dev if true

    /**
     * Configure command line options
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('mtg:import:all')
            ->setDescription('Import data from AllSets.json');
    }

    /**
     * Execute mtg:import:all
     *
     * @param InputInterface  $input  Command line input
     * @param OutputInterface $output Command line output
     *
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->em = $this->getContainer()->get("doctrine.orm.default_entity_manager");
        $this->em->getConnection()->getConfiguration()->setSQLLogger(null);

        $output->writeln('<info>Downloading json file</info>');

        if ($this->isDebug === false) {
            $download = file_get_contents('http://mtgjson.com/json/AllSets.json');

            if ($download === false) {
                $output->writeln('<error>Oups, file not find. Check your internet connection</error>');
                return false;
            } else {
                $output->writeln('<info>Download successful</info>');
                $data = json_decode($download, true);
                file_put_contents('cachecards.cache', serialize($data));
            }
        } else {
            $download = unserialize(file_get_contents("cachecards.cache"));

            if ($download === false) {
                $output->writeln('<error>Oups, Something went wrong. Debug mode is active</error>');
                return false;
            } else {
                $output->writeln('<info>Download successful</info>');
                $data = $download;
            }
        }

        foreach ($data as $content) {
            // Import set first

            $searchSet = $this->em->getRepository('OxhildMtgBundle:Set')
                ->findOneBy(['name' => $content['name']]);

            if ($searchSet === null) {

                $output->writeln('<info> Set not found, adding to database '.$content['name'].'</info>');

                $set = new Set();
                $settype = new Settype();

                $type = $this->em->getRepository('OxhildMtgBundle:Settype')
                    ->findOneBy(['name' => $content['type']]);

                if ($type === null) {
                    $output->writeln('<info> Set type not found, adding to database '.$content['type'].'</info>');

                    $settype->setName($content['type']);
                    $this->em->persist($settype);
                    $set->setType($settype);
                } else {
                    $output->writeln('<info> Set type exists, skipping</info>');
                    $set->setType($type);
                }

                $date = new DateTime($content['releaseDate']);

                $set->setName($content['name'])
                    ->setCode($content['code'])
                    ->setReleaseDate($date)
                    ->setBorders($content['border']);

                if (isset($content['magicCardsInfoCode'])) {
                    $set->setMagicCardsInfoCode($content['magicCardsInfoCode']);
                } else {
                    $set->setMagicCardsInfoCode(null);
                }

                if (isset($content['gathererCode'])) {
                    $set->setGathererCode($content['gathererCode']);
                } else {
                    $set->setGathererCode(null);
                }

                $this->em->persist($set);

                $progress = new ProgressBar($output, count($content['cards']));
                $progress->setFormatDefinition('very_verbose', 'Progress: %percent%%');

                $progress->start();

                //then add cards
                foreach ($content['cards'] as $cardData) {

                    $card = new Card();

                    // Layout
                    $searchLayout = $this->em->getRepository('OxhildMtgBundle:Layout')
                        ->findOneBy(["name" => $cardData['layout']]);

                    if ($searchLayout === null) {
                        $newLayout = new Layout();
                        $newLayout->setName($cardData['layout']);
                        $this->em->persist($newLayout);
                        $card->setLayout($newLayout);
                    } else {
                        $card->setLayout($searchLayout);
                    }
                    // End Layout

                    // Type
                    if (isset($cardData['types'])) {
                        foreach($cardData['types'] as $cardType) {

                            $searchType = $this->em->getRepository('OxhildMtgBundle:Type')
                                ->findOneBy(['name' => $cardType]);

                            if ($searchType === null) {
                                $newType = new Type();
                                $newType->setName($cardType);
                                $this->em->persist($newType);

                                $card->addType($newType);
                            } else {
                                $card->addType($searchType);
                            }
                        }
                    }
                    // End Type

                    //Colors
                    if  (isset($cardData['colors'])) {
                        foreach($cardData['colors'] as $color) {
                            $searchColor = $this->em->getRepository('OxhildMtgBundle:Color')
                                ->findOneBy(['color' => $color]);

                            if ($searchColor === null) {
                                $newColor = new MtgColor();
                                $newColor->setColor($color);
                                $this->em->persist($newColor);
                                $card->addColor($newColor);
                            } else {
                                $card->addColor($searchColor);
                            }
                        }
                    }
                    // End Colors

                    // Subtypes
                    if (isset($cardData['subtypes'])) {
                        foreach ($cardData['subtypes'] as $subtype) {
                            $searchSubt = $this->em->getRepository('OxhildMtgBundle:Subtype')
                                ->findOneBy(['name' => $subtype]);

                            if ($searchSubt === null) {
                                $newSubtype = new Subtype();
                                $newSubtype->setName($subtype);
                                $this->em->persist($newSubtype);
                                $card->addSubtype($newSubtype);
                            } else {
                                $card->addSubtype($searchSubt);
                            }
                        }
                    }
                    // End Subtypes

                    // Supertypes
                    if (isset($cardData['supertypes'])) {
                        foreach ($cardData['supertypes'] as $supertype) {
                            $searchSt = $this->em->getRepository('OxhildMtgBundle:Supertype')
                                ->findOneBy(['name' => $supertype]);

                            if ($searchSt === null) {
                                $newSupertype = new Supertype();
                                $newSupertype->setName($supertype);
                                $this->em->persist($newSupertype);
                                $card->addSupertype($newSupertype);
                            } else {
                                $card->addSupertype($searchSt);
                            }
                        }
                    }
                    // End Supertypes

                    // Rarity
                    $searchRarity = $this->em->getRepository('OxhildMtgBundle:Rarity')
                        ->findOneBy(['rarity' => $cardData['rarity']]);

                    if ($searchRarity === null) {
                        $newRarity = new Rarity();
                        $newRarity->setRarity($cardData['rarity']);
                        $this->em->persist($newRarity);
                        $card->setRarity($newRarity);
                    } else {
                        $card->setRarity($searchRarity);
                    }
                    // End Rarity

                    // Artist
                    $searchArtist = $this->em->getRepository('OxhildMtgBundle:Artist')
                        ->findOneBy(['name' => $cardData['artist']]);

                    if ($searchArtist === null) {
                        $newArtist = new Artist();
                        $newArtist->setName($cardData['artist']);
                        $this->em->persist($newArtist);
                        $card->setArtist($newArtist);
                    } else {
                        $card->setArtist($searchArtist);
                    }
                    // End Artist

                    $card->setType($cardData['type'])
                        ->setName($cardData['name'])
                        ->setImageName($cardData['imageName'])
                        ->setSet($set);

                    if (isset($cardData['multiverseid'])) {
                        $card->setMultiverseid($cardData['multiverseid']);
                    } else {
                        $card->setMultiverseid(null);
                    }

                    if (isset($cardData['number'])) {
                        $card->setNumber($cardData['number']);
                    } else {
                        $card->setNumber(null);
                    }

                    if (isset($cardData['power'])) {
                        $card->setPower($cardData['power']);
                    } else {
                        $card->setPower(null);
                    }

                    if (isset($cardData['toughness'])) {
                        $card->setToughness($cardData['toughness']);
                    } else {
                        $card->setToughness(null);
                    }

                    if (isset($cardData['flavor'])) {
                        $card->setFlavor($cardData['flavor']);
                    } else {
                        $card->setFlavor(null);
                    }

                    if (isset($cardData['text'])) {
                        $card->setText($cardData['text']);
                    } else {
                        $card->setText(null);
                    }

                    if (isset($cardData['cmc'])) {
                        $card->setCmc($cardData['cmc']);
                    } else {
                        $card->setCmc(0);
                    }

                    if (isset($cardData['manaCost'])) {
                        $card->setManaCost($cardData['manaCost']);
                    } else {
                        $card->setManaCost(0);
                    }

                    $this->em->persist($card);
                    $progress->advance();
                }
            } else {
                $output->writeln('<info> Set exists, skipping</info>');
            }
        }
        $output->writeln('<info>Waiting, flush is running</info>');
        $this->em->flush();
        return true;
    }
}
