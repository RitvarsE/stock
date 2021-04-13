<?php


namespace App\Services\Users;


use App\Repositories\Users\UsersRepository;

class UsersService
{

    private UsersRepository $usersRepository;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function createUser(string $username, string $password): void
    {
        $this->usersRepository->createUser($username, $password);
    }

    public function verifyUser(string $username, string $password): bool
    {
        return $this->usersRepository->verifyUser($username, $password);
    }

    public function getWallet(string $username): string
    {
        return $this->usersRepository->getWallet($username);
    }

    public function updateWallet(string $username, int $amount): void
    {
        $this->usersRepository->updateWallet($username, $amount);
    }
}