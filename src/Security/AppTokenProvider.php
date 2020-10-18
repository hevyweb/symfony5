<?php

namespace App\Security;

use App\Entity\RememberMeToken;
use App\Repository\RememberMeTokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\RememberMe\PersistentTokenInterface;
use Symfony\Component\Security\Core\Authentication\RememberMe\TokenProviderInterface;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;

class AppTokenProvider implements TokenProviderInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function loadTokenBySeries(string $series)
    {
        /**
         * @var RememberMeTokenRepository $rememberMeTokenRepo
         * @var RememberMeToken $rememberMeToken
         */
        $rememberMeTokenRepo = $this->entityManager->getRepository(RememberMeToken::class);
        $rememberMeToken = $rememberMeTokenRepo->findBySeries($series);

        if ($rememberMeToken) {
            return $rememberMeToken;
            //return new PersistentToken($row['class'], $row['username'], $series, $row['value'], new \DateTime($row['last_used']));
        }

        throw new TokenNotFoundException('No token found.');
    }

    /**
     * {@inheritdoc}
     */
    public function deleteTokenBySeries(string $series)
    {
        /**
         * @var RememberMeTokenRepository $rememberMeTokenRepo
         */
        $rememberMeTokenRepo = $this->entityManager->getRepository(RememberMeToken::class);
        $rememberMeTokenRepo->deleteBySeries($series);
    }

    /**
     * {@inheritdoc}
     */
    public function updateToken(string $series, string $tokenValue, \DateTime $lastUsed)
    {
        $rememberMeToken = $this->loadTokenBySeries($series);
        $rememberMeToken->setLastUsed($lastUsed);
        $rememberMeToken->setValue($tokenValue);
        $this->entityManager->persist($rememberMeToken);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function createNewToken(PersistentTokenInterface $token)
    {
        $rememberMeToken = new RememberMeToken();
        $rememberMeToken
            ->setValue($token->getTokenValue())
            ->setLastUsed($token->getLastUsed())
            ->setClass($token->getClass())
            ->setSeries($token->getSeries())
            ->setUsername($token->getUsername());
        $this->entityManager->persist($rememberMeToken);
        $this->entityManager->flush();
    }
}