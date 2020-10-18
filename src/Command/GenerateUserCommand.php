<?php

namespace App\Command;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class GenerateUserCommand extends Command
{
    protected static $defaultName = 'app:generate:user';

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->passwordEncoder = $passwordEncoder;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Generates admin user')
            ->addOption(
                'username',
                'u',
                InputOption::VALUE_OPTIONAL,
                'Username',
                'admin'
            )
            ->addOption(
                'password',
                'p',
                InputOption::VALUE_OPTIONAL,
                'User password',
                'admin'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $username = $input->getOption('username');
        $plainPassword = $input->getOption('password');
        /**
         * @var UserRepository $userRepository
         */
        $userRepository = $this->entityManager->getRepository(User::class);


        if ($userRepository->findOneBy(['username' => $username])) {
            $io->error('User with username "' . $username . '" already exists.');
            return 1;
        }
        $user = new User();
        $this->assignRoles($user);
        $this->assignUniqueEmail($user);
        $user
            ->setUsername($username)
            ->setFirstName($username)
            ->setLastName($username)
            ->setPlainPassword($plainPassword);
        $this->encodePassword($user);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success('New admin user created. Username: ' . $username . ', password: ' . $plainPassword);
        return 0;
    }

    /**
     * @param User $user
     * @return User
     */
    protected function assignUniqueEmail(User $user): User
    {
        do {
            $email = 'Change-me' . uniqid();
        } while($this->getUserRepository()->findOneBy(['email' => $email]));

        return $user->setEmail($email);
    }

    /**
     * @return UserRepository|ObjectRepository
     */
    private function getUserRepository(): UserRepository
    {
        return $this->entityManager->getRepository(User::class);
    }

    /**
     * @param User $user
     * @throws \RuntimeException
     * @return User
     */
    private function assignRoles(User $user): User
    {
        /**
         * @var Role $adminRole
         * @var Role $userRole
         * @var RoleRepository $roleRepository
         */
        $roleRepository = $this->entityManager->getRepository(Role::class);
        $adminRole = $roleRepository->findOneBy(['code' => 'ROLE_ADMIN']);
        $userRole = $roleRepository->findOneBy(['code' => 'ROLE_USER']);

        if (empty($adminRole) || empty($userRole)) {
            throw new \RuntimeException('Run migrations first. Roles have not been set yet');
        }

        return $user
            ->addRole($adminRole)
            ->addRole($userRole);
    }

    /**
     * @param User $user
     * @return User
     */
    private function encodePassword(User $user): User
    {
        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
        return $user->setPassword($password);
    }
}
