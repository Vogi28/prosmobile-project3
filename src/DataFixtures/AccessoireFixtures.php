<?php

namespace App\DataFixtures;

use App\Entity\Accessoire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AccessoireFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 20; $i++) {
            $accessoire = new Accessoire();
            $accessoire->setNom('Accessoire_' . $i);
            $accessoire->setPrix(1 . $i);
            $manager->persist($accessoire);
        }
        $manager->flush();
    }
}
