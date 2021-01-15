<?php

namespace App\Repository;

use App\Entity\Farmer;
use App\Entity\Filter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Farmer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Farmer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Farmer[]    findAll()
 * @method Farmer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FarmerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Farmer::class);
    }

    public function getFarmerWithData(): array
    {
        return $this->createQueryBuilder('f')
            ->select('c.city, c.latitude, c.longitude, f.id, f.registerYear, f.quantitySold, f.category, f.farmSize,
         f.comment, f.xpRate')
            ->join('App\Entity\City', 'c', 'WITH', 'c.id=f.city')
            ->getQuery()
            ->getResult();
    }

    public function getFilteredFarmers(Filter $filter)
    {
        $queryBuilder = $this->createQueryBuilder('f')
            ->select('c.city, c.latitude, c.longitude, f.id, f.registerYear, f.quantitySold, f.category, f.farmSize,
         f.comment, f.xpRate')
            ->join('App\Entity\City', 'c', 'WITH', 'c.id = f.city');
        if (!empty($filter->getCategory())) {
            $queryBuilder = $this->getByProduct($filter, $queryBuilder);
        }
        if (!empty($filter->getFarmSize())) {
            $queryBuilder = $this->getByFarmSize($filter, $queryBuilder);
        }

        return $queryBuilder->getQuery()->getResult();
    }

    private function getByProduct(Filter $filter, QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder = $queryBuilder
            ->join('App\Entity\Transaction', 't', 'WITH', 't.farmer = f.id')
            ->join('App\Entity\Product', 'p', 'WITH', 'p.id = t.product')
            ->where('p.category IN (:category)')
            ->setParameter('category', $filter->getCategory());
        return $queryBuilder;
    }

    private function getByFarmSize(Filter $filter, QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder = $queryBuilder
            ->andWhere('f.farmSize < :size')
            ->setParameter('size', $filter->getFarmSize());
        return $queryBuilder;
    }





























//    private function getByCategory(Filter $filter, QueryBuilder $queryBuilder): QueryBuilder
//    {
//        $queryBuilder = $queryBuilder
//            ->join('App\Entity\:role', 'r')
//            ->setParameter('role', $filter->getRole());
//        return $queryBuilder;
//    }


    // /**
    //  * @return Farmer[] Returns an array of Farmer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Farmer
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
