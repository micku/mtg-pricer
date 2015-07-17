<?php

namespace AppBundle\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mtg:import')
            ->setDescription('Import set files')
            ->addArgument(
                'set-code',
                InputArgument::OPTIONAL,
                'Set Code'
            )
            /*
            ->addOption(
               'yell',
               null,
               InputOption::VALUE_NONE,
               'If set, the task will yell in uppercase letters'
            )
             */
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $set = $input->getArgument('set-code');
        if ($set) {
            $filename = strtoupper($set);
        } else {
            $filename = 'ORI';
        }
        $filename .= '-x.json';
        $output->writeln('File to parse: '.$filename);

        $dir = $this->getContainer()->get('kernel')->getRootDir().'/Resources/CardsData/';
        $doctrine = $this->getContainer()->get('doctrine_mongodb');
        $dbmanager = $doctrine->getManager();

        $setJson = file_get_contents($dir.$filename);
        $setCards = json_decode($setJson, true);

        $setCode = $setCards['code'];
        $set = $doctrine->getRepository('AppBundle:BlockSet')
            ->findOneBy(array('code' => $setCode));

        if (!$set)
        {
            $set = new \AppBundle\Document\BlockSet();
            $set->setName($setCards['name']);
            $set->setCode($setCode);
            $set->setMagicCardsInfoCode(( array_key_exists('magicCardsInfoCode', $setCards) ? $setCards['magicCardsInfoCode'] : ''));
            $set->setBlock($setCards['type']);
            $dbmanager->persist($set);
            $dbmanager->flush();
        }
        else
        {
            // ToDo: Update
        }

        for ($i = 0; $i < count($setCards['cards']); $i++)
        {
            $card = $setCards['cards'][$i];
            $newCard = $doctrine->getRepository('AppBundle:Card')
                ->findBy(array('name' => $card['name'], 'imageName' => $card['imageName']));
            // ToDo: Add filter by set

            if (!$newCard)
            {
                $newCard = new \AppBundle\Document\Card();

                $newCard->setName($card['name']);
                $newCard->setImageName($card['imageName']);
                $newCard->addSet($set);
                $newCard->setManaCost(@$card['manaCost']);
                $newCard->setCmc(@$card['cmc']);
                $newCard->setType(@$card['type']);
                $newCard->setText(@$card['text']);
                $newCard->setFlavor(@$card['flavor']);
                $newCard->setArtist(@$card['artist']);
                $newCard->setNumber(@$card['number']);
                $newCard->setPower(@$card['power']);
                $newCard->setToughness(@$card['toughness']);
                $newCard->setLayout(@$card['layout']);
                $newCard->setMultiverseId(@$card['multiverseid']);

                //// Add Foreign names and languages
                $languagestr = 'English';
                $namestr = $card['name'];

                $language = $doctrine->getRepository('AppBundle:Language')
                    ->findOneBy(array('name' => $languagestr));
                if (!$language)
                {
                    $language = new \AppBundle\Document\Language();
                    $language->setName($languagestr);
                    $dbmanager->persist($language);
                    $dbmanager->flush();
                }

                $name = new \AppBundle\Document\ForeignName();
                $name->setName($namestr);
                $name->setLanguage($language);
                $newCard->addForeignName($name);

                if (array_key_exists('foreignNames', $card))
                {
                    foreach($card['foreignNames'] as &$foreignName)
                    {
                        $languagestr = $foreignName['language'];
                        $namestr = $foreignName['name'];

                        $language = $doctrine->getRepository('AppBundle:Language')
                            ->findOneBy(array('name' => $languagestr));
                        if (!$language)
                        {
                            $language = new \AppBundle\Document\Language();
                            $language->setName($languagestr);
                            $dbmanager->persist($language);
                            $dbmanager->flush();
                        }

                        $name = new \AppBundle\Document\ForeignName();
                        $name->setName($namestr);
                        $name->setLanguage($language);
                        $newCard->addForeignName($name);
                    }
                }

                //// Add Types
                $types = $this->insertReference(
                    $card,
                    'types',
                    $dbmanager,
                    $doctrine,
                    'AppBundle:Type',
                    '\AppBundle\Document\Type'
                );
                foreach($types as &$type)
                {
                    $newCard->addType($type);
                }

                //// Add Rarity
                $rarities = $this->insertReference(
                    $card,
                    'rarity',
                    $dbmanager,
                    $doctrine,
                    'AppBundle:Rarity',
                    '\AppBundle\Document\Rarity'
                );
                foreach($rarities as &$rarity)
                {
                    $newCard->setRarity($rarity);
                }

                //// Add SubTypes
                $subTypes = $this->insertReference(
                    $card,
                    'subtypes',
                    $dbmanager,
                    $doctrine,
                    'AppBundle:SubType',
                    '\AppBundle\Document\SubType'
                );
                foreach($subTypes as &$subType)
                {
                    $newCard->addSubType($subType);
                }

                //// Add SuperTypes
                $superTypes = $this->insertReference(
                    $card,
                    'superTypes',
                    $dbmanager,
                    $doctrine,
                    'AppBundle:SuperType',
                    '\AppBundle\Document\SuperType'
                );
                foreach($superTypes as &$superType)
                {
                    $newCard->addType($superType);
                }

                //// Add Formats
                $legalities = $this->insertReference(
                    $card,
                    'legalities',
                    $dbmanager,
                    $doctrine,
                    'AppBundle:Format',
                    '\AppBundle\Document\Format'
                );
                foreach($legalities as &$legality)
                {
                    $newCard->addFormat($legality);
                }

                //// Add Rulings
                if (array_key_exists('rulings', $card))
                {
                    foreach($card['rulings'] as $rulingstr)
                    {
                        $date = strtotime($rulingstr['date']);
                        $date = new \DateTime($rulingstr['date']);
                        $ruling = new \AppBundle\Document\Ruling();
                        $ruling->setDate($date);
                        $ruling->setText($rulingstr['text']);
                        $newCard->addRuling($ruling);
                    }
                }

                //// Add Colors
                $colors = $this->insertReference(
                    $card,
                    'colors',
                    $dbmanager,
                    $doctrine,
                    'AppBundle:Color',
                    '\AppBundle\Document\Color'
                );
                foreach($colors as &$color)
                {
                    $newCard->addColor($color);
                }

                //// Persist Card object
                $dbmanager->persist($newCard);
                $dbmanager->flush();

                $output->writeln('Card '.$newCard->getName().' written.');
            }
            else
            {
                /*
                $newCard = $newCard[0];
                $newCard->addSet($set);

                $dbmanager->persist($newCard);
                $dbmanager->flush();

                $output->writeln('Card '.$newCard->getName().' written.');
                 */
            }
        }
    }

    protected function insertReference(
        $card,
        $cardIndex,
        $dbmanager,
        $doctrine,
        $doctrineType,
        $type
    )
    {
        $objs = Array();
        if (array_key_exists($cardIndex, $card))
        {
            if (gettype($card[$cardIndex]) == 'array')
            {
                foreach($card[$cardIndex] as $keystr => $valstr)
                {
                    if (gettype($keystr) == 'string')
                    {
                        $valstr = $keystr;
                    }

                    $objs[] = $this->createInstance(
                        $doctrineType,
                        $valstr,
                        $type,
                        $dbmanager,
                        $doctrine
                    );
                }
            }
            else
            {
                $objs[] = $this->createInstance(
                    $doctrineType,
                    $card[$cardIndex],
                    $type,
                    $dbmanager,
                    $doctrine
                );
            }
        }
        return $objs;
    }

    protected function createInstance(
        $doctrineType,
        $valstr,
        $type,
        $dbmanager,
        $doctrine
    )
    {
        $val = $doctrine->getRepository($doctrineType)
            ->findOneBy(array('name' => $valstr));
        if (!$val)
        {
            $val = new $type();
            if (method_exists($val, 'setName'))
            {
                $val->setName($valstr);
            }

            $dbmanager->persist($val);
            $dbmanager->flush();
        }
        return $val;
    }
}
