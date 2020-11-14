<?php

namespace App\Repository;

use App\Entity\ImageLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageLog[]    findAll()
 * @method ImageLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageLog::class);
    }

    public function paginate($page, $limit)
    {
        return $this->createQueryBuilder('i')
            ->select('i')
            ->setMaxResults($limit)
            ->setFirstResult(($page-1)*$limit)
            ->getQuery()
            ->getArrayResult();
    }

    public function getTotalCount(): int
    {
        return $this->createQueryBuilder('i')
            ->select('count(i.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
