<?php

namespace App\Repository;

use App\Entity\ProductTest1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductTest1|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductTest1|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductTest1[]    findAll()
 * @method ProductTest1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductTest1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductTest1::class);
    }

    // /**
    //  * @return ProductTest1[] Returns an array of ProductTest1 objects
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
    public function findOneBySomeField($value): ?ProductTest1
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
