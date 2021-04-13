<?php


namespace App\Repositories\Stock;


use Medoo\Medoo;
use PDO;
use PDOStatement;

class MySQLStockRepository implements StockRepository
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

    public function allStock(string $username): array
    {
        return $this->database->select('stock',
            ['stockName', 'stockPriceBought', 'stockAmount', 'stockPriceNow', 'active', 'stockSold', 'id'],
            ['username' => $username]);
    }

    public function buy(string $username, string $stock, string $price, string $count): void
    {
        $this->database->insert('stock',
            ['userName' => $username,
                'stockName' => $stock,
                'stockPriceBought' => $price,
                'stockAmount' => $count]);
    }

    public function sell(string $id, string $sellPrice): void
    {
        $this->database->update('stock', ['active' => false, 'stockSold' => $sellPrice], ['id' => $id]);
    }

    public function addCurrentPrice(): void
    {
        $stocks = $this->database->select('stock', 'stockName');
        foreach ($stocks as $stock) {
            $price = json_decode(
                file_get_contents(
                    'https://finnhub.io/api/v1/quote?symbol=' . $stock . '&token=c1pj3v2ad3id1hoq2ap0')
                , true)['c'];
            $this->database->update('stock', ['StockPriceNow' => $price], ['stockName' => $stock, 'active' => true]);
        }
    }
}