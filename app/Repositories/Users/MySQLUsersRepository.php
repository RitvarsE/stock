<?php


namespace App\Repositories\Users;


use Medoo\Medoo;
use PDO;
use function PHPUnit\Framework\throwException;

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

    /**
     * @throws \ErrorException
     */
    public function createUser(string $username, string $password): void
    {
        if ($this->checkUser($username)) {
            echo 'user with that username already exists';
        } else {
            $this->database->insert('user', ['userName' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT), 'Wallet' => 1000]);
        }
    }

    public function checkUser(string $username): bool
    {
        return $this->database->has('user', ['userName' => $username]);
    }

    public function verifyUser(string $username, string $password): bool
    {
        $hash = $this->database->get('user', ['userName', 'password'], ['userName' => $username]);
        return $hash['userName'] === $username && password_verify($password, $hash['password']);
    }
}