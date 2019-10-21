<?php

namespace App\Repository;

use App\Entity\ProductTest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductTest|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductTest|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductTest[]    findAll()
 * @method ProductTest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductTestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductTest::class);
    }

    // /**
    //  * @return ProductTest[] Returns an array of ProductTest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductTest
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
