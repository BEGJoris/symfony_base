<?php

namespace App\DataFixtures;

use App\Entity\Burger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BurgerFixtures extends Fixture
{
    private const BURGER_REFERENCE = "Burger";

    public function load(ObjectManager $manager): void
    {
        $Burgers=[
            [
                "name" => "Burger",
                "price" => 14.99,
                "pain_id" => 1,
                "sauce_id" => 1,

            ],
            [
                "name" => "Cheeseburger",
                "price" => 15.99,
                "pain_id" => 1,
                "sauce_id" => 1,
            ],
            [
                "name" => "BaconCheeseburger",
                "price" => 16.99,
                "pain_id" => 1,
                "sauce_id" => 1,
            ],
        ];

        foreach ($Burgers as $key => $value) {
            $product = new Burger();
            $product->setName($value["name"]);
            $product->setPrice($value["price"]);
//            $product->setPain($value["pain_id"]);
//            $product->setSauce($value["sauce_id"]);
            $manager->persist($product);
            $this->addReference(self::BURGER_REFERENCE.'_'.$key, $product);
        }


        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
