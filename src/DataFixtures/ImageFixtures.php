<?php

namespace App\DataFixtures;

use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture

{
    private const IMAGE_REFERENCE = 'image';
    public function load(ObjectManager $manager): void
    {
        $nomsImages=[
            "image1.jpg",
            "image2.jpg",
            "image3.jpg",
        ];

        foreach ($nomsImages as $key => $value) {
            $product = new Image();
            $product->setName($value);
            $manager->persist($product);
            $this->addReference(self::IMAGE_REFERENCE . '_' . $key, $product);
        }

        $manager->flush();
    }
}
