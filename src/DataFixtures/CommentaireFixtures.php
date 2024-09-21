<?php

namespace App\DataFixtures;

use App\Entity\Commentaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CommentaireFixtures extends Fixture
{
    private const COMMENTAIRE_REFERENCE = 'commentaire';
    public function load(ObjectManager $manager): void
    {
        $nomsCommentaires=[
            "Bon",
            "Mauvais",
            "C'est parfait"
        ];

        foreach ($nomsCommentaires as $key => $value) {
            $product = new Commentaire();
            $product->setName($value);
            $manager->persist($product);
        }


        $manager->flush();
    }
}
