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
        $query = $this->createQueryBuilder('b')
            ->leftJoin('b.oignon', 'o')
            ->leftJoin('b.sauce', 's')
            ->where('o.id = :oignon OR s.id = :sauce')
            ->setParameter('oignon', $ingredient->getId())
            ->setParameter('sauce', $ingredient->getId())
            ->getQuery()
            ->getResult();
        return $query;
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
            dump($table);


//            if (empty($table)) {
//                return [];
//            }
            $query = $this->createQueryBuilder('b')
                ->leftJoin("{$table}", "i")

//                ->where("b.$table IS NULL OR b.$table NOT IN (:ingredient)")
//                ->setParameter('ingredient', $ingredient->getName())
                ->getQuery();

            return $query->getResult();

        }

        public function findBurgersWithMinimumIngredients(int $minIngredients){

            return $this->createQueryBuilder('b')
                ->leftJoin('b.ingredient', 'i')
                ->groupBy('b')
                ->having('COUNT(i) >= :minIngredients')
                ->setParameter('minIngredients', $minIngredients)
                ->getQuery()
                ->getResult();
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
