<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $this->entityManager->getRepository(User::class);
    }

    /**
     * @param int $id
     * @return User
     */
    public function find(int $id): User
    {
        $user = $this->userRepository->find($id);
        return $user;
    }

    /**
     * @param User $user
     * @return User
     */
    public function findOneBy(User $user): User
    {
        $user = $this->userRepository->findOneBy(
            array(
                'email' => $user->getEmail(),
                'password' => $user->getPassword()
            )
        );

        return $user;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $users = $this->userRepository->findAll();
        return $users;
    }

    /**
     * @param User $user
     */
    public function save(User $user): void
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    /**
     * @param User $user
     */
    public function delete(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }
}
