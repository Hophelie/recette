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
            $product->setNom($value);
            $product->setImage($value);
            $product->setPrix(mt_rand(1, 10));
            $product->setCalories(mt_rand(1, 70));
            $product->setProteines(mt_rand(1, 70));
            $product->setGlucides(mt_rand(1, 70));
            $product->setLipides(mt_rand(1, 70));
            $manager->persist($product);
        }

        $manager->flush();
    }
}
