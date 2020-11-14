<?php

namespace App\Repository;

use App\Entity\Oauth;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Oauth|null find($id, $lockMode = null, $lockVersion = null)
 * @method Oauth|null findOneBy(array $criteria, array $orderBy = null)
 * @method Oauth[]    findAll()
 * @method Oauth[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OauthRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Oauth::class);
    }

    public function upsert(array $tokens, User $user, string $code)
    {
        $oauth = $this->findOneBy([
            'user' => $user
        ]);
        if (empty($oauth)) {
            $oauth = new Oauth();
            $oauth->setUser($user);
        }

        $oauth->setAccessToken($tokens['access_token'])
            ->setRefreshToken($tokens['refresh_token'])
            ->setExpirationDate(new \DateTime('+ ' . (int) $tokens['expires_in'] . ' seconds'))
            ->setCreatedAt(new \DateTime())
            ->setCode($code);
        $this->getEntityManager()->persist($oauth);
        $this->getEntityManager()->flush();
    }
}
