<?php


namespace App\Repositories\Users;


use Medoo\Medoo;
use PDO;

class MySQLUsersRepository implements UsersRepository
{
    private Medoo $database;

    public function __construct()
    {
        $pdo = new PDO('mysql:dbname=stock;host=localhost', 'root', 'kartupelis');
        $this->database = new Medoo([
            'pdo' => $pdo,
            'database_type' => 'mysql'
        ]);
    }

    public function createUser(string $username, string $password): bool
    {
        if ($this->checkUser($username)) {
            return false;
        } else {
            $this->database->insert('user', ['userName' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT), 'Wallet' => 100000]);
            return true;
        }
    }

    public function checkUser(string $username): bool
    {
        return $this->database->has('user', ['userName' => $username]);
    }

    public function verifyUser(string $username, string $password): bool
    {
        if (empty($username) || empty($password) || !$this->checkUser($username)) {
            return false;
        } else {
            $hash = $this->database->get('user', ['userName', 'password'], ['userName' => $username]);
            return $hash['userName'] === $username && password_verify($password, $hash['password']);
        }
    }

    public function getWallet(string $username): ?float
    {
        return $this->database->get('user', 'Wallet', ['userName' => $username]);
    }

    public function updateWallet(string $username, float $amount): void
    {
        $this->database->update('user', ['Wallet' => ($this->getWallet($username) - $amount)], ['userName' => $username]);
    }
}