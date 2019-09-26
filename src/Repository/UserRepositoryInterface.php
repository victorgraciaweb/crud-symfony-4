<?php

namespace App\Repository;

use App\Entity\User;

interface UserRepositoryInterface
{
    /**
     * @param int $id
     * @return User
     */
    public function find(int $id): User;

    /**
     * @param User $user
     * @return User
     */
    public function findOneBy(User $user): User;

    /**
     * @return array
     */
    public function findAll(): array;

    /**
     * @param User $user
     */
    public function save(User $user): void;

    /**
     * @param User $user
     */
    public function delete(User $user): void;
}