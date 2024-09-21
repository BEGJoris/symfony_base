<?php

namespace App\DataFixtures;

use App\Entity\Pain;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PainFixtures extends Fixture

{
    private const PAIN_REFERENCE = "Pain";
    public function load(ObjectManager $manager): void
    {
        $nomsPains=[
            "Pain classique",
            "Pain baguette",
            "Pain complet",
        ];

        foreach ($nomsPains as $key => $value) {
            $product = new Pain();
            $product->setName($value);
            $manager->persist($product);
            $this->addReference(self::PAIN_REFERENCE .'_'. $key, $product);
        }

        $manager->flush();
    }
}
