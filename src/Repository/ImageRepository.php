<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends AbstractDataGridRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function getLatestImageRecord()
    {
        $image = $this->createQueryBuilder('i')
            ->where('i.locked_at IS NULL')
            ->orderBy('i.created_at', 'asc')
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();

        $image->setLockedAt(new \DateTime());
        $this->getEntityManager()->persist($image);
        $this->getEntityManager()->flush($image);
        return $image;
    }

    public function getImagesPerPage(?int $page = 1, ?int $perPage = 100, Criteria $criteria)
    {
        return $this->createQueryBuilder('i')
            ->addCriteria($criteria)
            ->setMaxResults($perPage)
            ->setFirstResult(($page - 1) * $perPage)
            ->getQuery()
            ->getResult();
    }

    public function getDeleted()
    {
        return $this->createQueryBuilder('i')
            ->where('deleted', true)
            ->getQuery()
            ->getResult();
    }
}
