<?php

namespace App\Repository;

use App\Entity\Farmer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function getFarmerCountByCity(): array
    {
        return $this->createQueryBuilder('f')
            ->select('c.city, c.latitude, c.longitude, COUNT(f.id) as farmers')
            ->join('App\Entity\City', 'c', 'WITH', 'c.id=f.city')
            ->groupBy('f.city')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getFarmersByFarmSize(int $size)
    {
        return $this->createQueryBuilder('f')
            ->select('c.city, c.latitude, c.longitude, f.farmSize')
            ->join('App\Entity\City', 'c', 'WITH', 'c.id = f.city')
            ->where('f.farmSize < :size')
            ->setParameter('size', $size)
            ->getQuery()
            ->getResult();
    }

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
