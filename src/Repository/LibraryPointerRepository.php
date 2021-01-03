<?php

namespace App\Repository;

use App\Entity\LibraryPointer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LibraryPointer|null find($id, $lockMode = null, $lockVersion = null)
 * @method LibraryPointer|null findOneBy(array $criteria, array $orderBy = null)
 * @method LibraryPointer[]    findAll()
 * @method LibraryPointer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LibraryPointerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LibraryPointer::class);
    }

    // /**
    //  * @return LibraryPointer[] Returns an array of LibraryPointer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LibraryPointer
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
