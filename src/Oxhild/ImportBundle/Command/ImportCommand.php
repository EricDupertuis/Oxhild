<?php

namespace Oxhild\ImportBundle\Command;

use Oxhild\MtgBundle\Entity\Artist;
use Oxhild\MtgBundle\Entity\Rarity;
use Oxhild\MtgBundle\Entity\Subtype;
use Proxies\__CG__\Oxhild\MtgBundle\Entity\Color;
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
use Oxhild\MtgBundle\Entity\Color as MtgColor;
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

            $exist = $this->em->getRepository('OxhildMtgBundle:Set')->findOneBy(
                array('name' => $content['name'])
            );

            if ($exist === null) {

                $output->writeln('<info>Set not found, adding to database</info>');

                $set = new Set();
                $settype = new Settype();

                $type = $this->em->getRepository('OxhildMtgBundle:Settype')->findOneBy(
                    array('name' => $content['type'])
                );

                if ($type == null) {
                    $output->writeln('<info>Set type not found, adding to database</info>');

                    $settype->setName($content['type']);
                    $this->em->persist($settype);

                    $type = $this->em->getRepository('OxhildMtgBundle:Settype')->findOneBy(["name" => $content['type']]);
                } else {
                    $output->writeln('<info>Set type exists, skipping</info>');
                    $type = $this->em->getRepository('OxhildMtgBundle:Settype')->findOneBy(["name" => $content['type']]);
                }

                $date = new DateTime($content['releaseDate']);

                $set->setName($content['name'])
                    ->setCode($content['code'])
                    ->setMagicCardsInfoCode($content['magicCardsInfoCode'])
                    ->setReleaseDate($date)
                    ->setBorders($content['border'])
                    ->setType($type);

                if (isset($content['gathererCode'])) {
                    $set->setGathererCode($content['gathererCode']);
                } else {
                    $set->setGathererCode(null);
                }

                $this->em->persist($set);

                //then add cards
                foreach ($content['cards'] as $cardData) {
                    $card = new Card();

                    // Layout
                    $searchLayout = $this->em->getRepository('OxhildMtgBundle:Layout')->findOneBy(["name" => $cardData['layout']]);

                    if ($searchLayout === null) {
                        $newLayout = new Layout();
                        $newLayout->setName($cardData['layout']);
                        $this->em->persist($newLayout);
                        $card->addLayout($newLayout);
                    } else {
                        $card->addLayout($searchLayout);
                    }
                    // End Layout

                    // Type
                    foreach($cardData['types'] as $cardType) {

                        $searchType = $this->em->getRepository('OxhildMtgBundle:Type')->findOneBy(['name' => $cardType]);

                        if ($searchType === null) {
                            $newType = new Type();
                            $newType->setName($cardType);
                            $this->em->persist($newType);

                            $card->addType($newType);
                        } else {
                            $card->addType($searchType);
                        }
                    }
                    // End Type

                    //Colors
                    if  (isset($cardData['colors'])) {
                        foreach($cardData['colors'] as $color) {
                            $searchColor = $this->em->getRepository('OxhildMtgBundle:Color')->findOneBy(['color' => $color]);

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
                            $searchSubt = $this->em->getRepository('OxhildMtgBundle:Subtype')->findOneBy(['name' => $subtype]);

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

                    // Rarity
                    $searchRarity = $this->em->getRepository('OxhildMtgBundle:Rarity')->findOneBy(['rarity' => $cardData['rarity']]);

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
                    $searchArtist = $this->em->getRepository('OxhildMtgBundle:Artist')->findOneBy(['name' => $cardData['artist']]);

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
                        ->setMultiverseid($cardData['multiverseid'])
                        ->setName($cardData['name'])
                        ->setImageName($cardData['imageName']);

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
                    $output->writeln('<info>Added card '.$cardData['name'].'</info>');
                    $this->em->flush();
                }
            } else {
                $output->writeln('<info>Set exists, skipping</info>');
            }
        }
    }
}
