<?php

namespace App\DataFixtures;

use App\Entity\Oignon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OignonFixtures extends Fixture


{
    private const OIGNON_REFERENCE = "Oignon";
    public function load(ObjectManager $manager): void
    {
        $nomsOignons=[
            "Oignon classique",
            "Oignon rouge"
        ];

        foreach ($nomsOignons as $key => $value) {
            $product = new Oignon();
            $product->setName($value);
            $manager->persist($product);
            $this->addReference(self::OIGNON_REFERENCE .'_'. $key, $product);
        }

        $manager->flush();
    }
}
