<?php


namespace App\Repositories\Users;


interface UsersRepository
{
    public function createUser(string $username, string $password): void;

    public function checkUser(string $username): bool;

    public function verifyUser(string $username, string $password): bool;

    public function getWallet(string $username): string;

    public function updateWallet(string $username, int $amount): void;
}