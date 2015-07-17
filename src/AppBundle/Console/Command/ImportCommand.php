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
        $set = $input->getArgument('set-code');
        if ($set) {
            $filename = strtoupper($set);
        } else {
            $filename = 'ORI';
        }
        $filename .= '-x.json';

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

                if (array_key_exists('colors', $card))
                {
                    foreach($card['colors'] as &$colorstr)
                    {
                        $color = $doctrine->getRepository('AppBundle:Color')
                            ->findOneBy(array('name' => $colorstr));
                        if (!$color)
                        {
                            $color = new \AppBundle\Document\Color();
                            $color->setName($colorstr);
                            $dbmanager->persist($color);
                            $dbmanager->flush();
                        }
                        $newCard->addColor($color);
                    }
                }

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
                //$name->setCard($newCard);
                //$dbmanager->persist($name);
                //$dbmanager->flush();
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
                        //$name->setCard($newCard);
                        //$dbmanager->persist($name);
                        $newCard->addForeignName($name);
                    }
                }

                $dbmanager->persist($newCard);
                $dbmanager->flush();

                $output->writeln('Card '.$newCard->getName().' written.');
            }
            else
            {
                $newCard->addSet($set);

                $dbmanager->persist($newCard);
                $dbmanager->flush();

                $output->writeln('Card '.$newCard->getName().' written.');
            }
        }
    }
}
