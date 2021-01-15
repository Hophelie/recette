<?php

namespace App\DataFixtures;

use App\Entity\Aliment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       
        $aliments = ['banane', 'carotte', 'cerise', 'champignon', 'choufleur', 'clementine', 'fenouil', 'fraise', 'haricot', 'poire', 'poireau', 'pomme', 'tomate'];

        foreach ($aliments as $key => $value) {

            $product = new Aliment();
            $product->setNom($value)
            ->setImage($value)
            ->setPrix(mt_rand(1, 10))
            ->setCalories(mt_rand(1, 70))
            ->setProteines(mt_rand(1, 70))
            ->setGlucides(mt_rand(1, 70))
            ->setLipides(mt_rand(1, 70));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
