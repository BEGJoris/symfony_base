<?php

namespace App\Repository;

use App\Entity\Burger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Burger>
 */
class BurgerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Burger::class);
    }
    //SELECT * FROM app.burger,app.burger_oignon
    //WHERE app.burger.id=app.burger_oignon.burger_id

    public function findBurgerWithIngredient(string $ingredient): array{
        // Cette requete devra utiliser DQL pour sélectionner tous les burgers contenant un ingrédient donné

        $entityManager = $this->getEntityManager();

        $query = $this->createQueryBuilder('b')
            ->innerJoin("b.{$ingredient}", 'o')
            ->getQuery();
        return $query->getResult();
    }

        public function findTopXBurgers(int $limit){

            return $this->createQueryBuilder('b')
                ->orderBy('b.price', 'DESC')
                ->setMaxResults($limit)
                ->getQuery()
                ->getResult();
        }

        public function findBurgersWithoutIngredient(object $ingredient): array{
            $table = "";
            switch ($ingredient::class) {
                case "App\Entity\Oignon":
                    $table = "oignon";
                    break;
                case "App\Entity\Sauce":
                    $table = "sauce";
                    break;
                case "App\Entity\Pain":
                    $table = "pain";
                    break;
            }
            $query = $this->createQueryBuilder('b')
                ->leftJoin("b.{$table}", "i")
                ->where("i IS NULL")
                ->getQuery();

            return $query->getResult();

        }

        public function findBurgersWithMinimumIngredients(int $minIngredients){
            // Nuance avoir au moins 2 fois le même ingrédient par exemple avoir 2 type d'oignons
            // ou avoir 2 ingrédients différents (sauce,oignon)
            // On va traiter le 2ème cas
            $query = $this->createQueryBuilder('b')
                ->innerJoin("b.oignon", "o")
                ->innerJoin("b.sauce", "s")
                ->innerJoin("b.pain", "p")
                ->groupBy('b.id')
                ->having("COUNT(o) + COUNT(s) + COUNT(p) >= :min")
                ->setParameter("min", $minIngredients)
                ->getQuery();
            return $query->getResult();
        }

    //    /**
    //     * @return Burger[] Returns an array of Burger objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Burger
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
