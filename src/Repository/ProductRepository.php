<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function getQueryForTransactionsByCategory(): string
    {
        return 'SELECT p.category as label, COUNT(t.id) as transactions 
        FROM App\Entity\Product p 
        JOIN App\Entity\Transaction t
        WITH p.id=t.product 
        GROUP BY p.category';
    }

    public function getQueryForTransactionsByCategoryWithLabels(): string
    {
        return 'SELECT CONCAT(p.category, \' prix moyen : \', AVG(t.price), \'€/t\') as label, COUNT(t.id) as transactions
        FROM App\Entity\Product p          
        JOIN App\Entity\Transaction t         
        WITH p.id=t.product          
        GROUP BY p.category';
    }
    // /**
    //  * @return Product[] Returns an array of Product objects
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
    public function findOneBySomeField($value): ?Product
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
