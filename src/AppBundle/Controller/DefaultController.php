<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     */
    public function indexAction()
    {
        $cards = $this->get('doctrine_mongodb')
            ->getRepository('AppBundle:BlockSet')
            ->findAll();

        return $this->render('default/index.html.twig', array(
            'cards' => $cards
        ));
    }

    /**
     * @Route("/", name="homepagepost")
     * @Method("POST")
     */
    public function reloadDataAction()
    {
        $dir = $this->get('kernel')->getRootDir().'/Resources/CardsData/';
        $doctrine = $this->get('doctrine_mongodb');
        $dbmanager = $doctrine->getManager();

        $filename = 'ORI-x.json';

        $setJson = file_get_contents($dir.$filename);
        $setCards = json_decode($setJson, true);

        //echo(count($setCards).'<br/>');
        //var_dump($setCards);

        $setCode = $setCards['code'];
        //$dql = "SELECT s.id, s.name, s.code, s.block, s.magic_cards_info_code FROM set s ".
            //"WHERE s.code = '".$setCode."'";
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

                /*
                foreach($card['types'] as &$typestr)
                {
                    $type = $doctrine->getRepository('AppBundle:Type')
                        ->findOneBy(array('name' => $typestr));
                    if (!$type)
                    {
                        $type = new \AppBundle\Document\Type();
                        $type->setName($typestr);
                        $dbmanager->persist($type);
                        $dbmanager->flush();
                    }
                    $newCard->addType($type);

                }

                if (array_key_exists('rarity', $card))
                {
                    $raritystr = $card['rarity'];
                    $rarity = $doctrine->getRepository('AppBundle:Rarity')
                        ->findOneBy(array('name' => $raritystr));
                    if (!$rarity)
                    {
                        $rarity = new \AppBundle\Document\Rarity();
                        $rarity->setName($raritystr);
                        $dbmanager->persist($rarity);
                        $dbmanager->flush();
                    }
                    $newCard->setRarity($rarity);
                }

                if (array_key_exists('subtypes', $card))
                {
                    foreach($card['subtypes'] as &$subTypestr)
                    {
                        $subType = $doctrine->getRepository('AppBundle:SubType')
                            ->findOneBy(array('name' => $subTypestr));
                        if (!$subType)
                        {
                            $subType = new \AppBundle\Document\SubType();
                            $subType->setName($subTypestr);
                            $dbmanager->persist($subType);
                            $dbmanager->flush();
                        }
                        $newCard->addSubType($subType);
                    }
                }

                if (array_key_exists('supertypes', $card))
                {
                    foreach($card['supertypes'] as &$superTypestr)
                    {
                        $superType = $doctrine->getRepository('AppBundle:SuperType')
                            ->findOneBy(array('name' => $superTypestr));
                        if (!$superType)
                        {
                            $superType = new \AppBundle\Document\SuperType();
                            $superType->setName($superTypestr);
                            $dbmanager->persist($superType);
                            $dbmanager->flush();
                        }
                        $newCard->addSuperType($superType);
                    }
                }

                if (array_key_exists('legalities', $card))
                {
                    foreach($card['legalities'] as $format => $legalitiestr)
                    {
                        $legality = $doctrine->getRepository('AppBundle:Legality')
                            ->findOneBy(array('format' => $format, 'isLegal' => $legalitiestr));
                        if (!$legality)
                        {
                            $legality = new \AppBundle\Document\Legality();
                            $legality->setFormat($format);
                            $legality->setIsLegal($legalitiestr);
                            $dbmanager->persist($legality);
                            $dbmanager->flush();
                        }
                        $newCard->addLegality($legality);
                    }
                }

                if (array_key_exists('rulings', $card))
                {
                    foreach($card['rulings'] as $rulingstr)
                    {
                        $date = strtotime($rulingstr['date']);
                        $date = new \DateTime($rulingstr['date']);
                        $ruling = $doctrine->getRepository('AppBundle:Ruling')
                            ->findOneBy(array('date' => $date, 'text' => $rulingstr));
                        if (!$ruling)
                        {
                            $ruling = new \AppBundle\Document\Ruling();
                            $ruling->setDate($date);
                            $ruling->setText($rulingstr['text']);
                            $dbmanager->persist($ruling);
                            $dbmanager->flush();
                        }
                        $newCard->addRuling($ruling);
                    }
                }



                $dbmanager->persist($newCard);
                $dbmanager->flush();
                 */
            }
            else
            {
                // ToDo: Update
            }
        }
        

    }
}
