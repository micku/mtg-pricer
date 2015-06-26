<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Card;

class LoadTestData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $newCard = new Card();
        $newCard->setName('Lord of the Pit');

        $manager->persist($newCard);
        $manager->flush();
    }
}
