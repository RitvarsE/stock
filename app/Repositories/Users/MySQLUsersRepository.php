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
            $this->database->insert('user', ['user_name' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT), 'wallet' => 100000]);
            return true;
        }
    }

    public function checkUser(string $username): bool
    {
        return $this->database->has('user', ['user_name' => $username]);
    }

    public function verifyUser(string $username, string $password): bool
    {
        if (empty($username) || empty($password) || !$this->checkUser($username)) {
            return false;
        } else {
            $hash = $this->database->get('user', ['user_name', 'password'], ['user_name' => $username]);
            return $hash['user_name'] === $username && password_verify($password, $hash['password']);
        }
    }

    public function getWallet(string $username): ?float
    {
        return $this->database->get('user', 'wallet', ['user_name' => $username]);
    }

    public function updateWallet(string $username, float $amount): void
    {
        $this->database->update('user', ['wallet' => ($this->getWallet($username) - $amount)], ['user_name' => $username]);
    }
}