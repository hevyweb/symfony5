<?php

namespace App\Repository;

use App\Entity\RememberMeToken;
use Doctrine\ORM\EntityRepository;

class RememberMeTokenRepository extends EntityRepository
{
    public function findBySeries(string $series): ? RememberMeToken
    {
        return $this->findOneBy(['series' => $series]);
    }

    public function deleteBySeries(string $series): bool
    {
        $rememberMeToken = $this->findBySeries($series);
        if (!empty($rememberMeToken)) {
            $this->getEntityManager()->remove($rememberMeToken);
            $this->getEntityManager()->flush();
            return true;
        }
        return false;
    }

}