<?php

namespace App\DataFixtures;

use App\Entity\Composant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ComposantFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 20; $i++) {
            $composant = new Composant();
            $composant->setNom('Composant ' . $i);
            $composant->setPrix(rand(20, 50));
            $manager->persist($composant);
        }
        $manager->flush();
    }
}
