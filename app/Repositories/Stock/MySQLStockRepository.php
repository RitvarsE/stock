<?php


namespace App\Repositories\Stock;


use App\Repositories\Quote\QuoteRepository;
use Medoo\Medoo;
use PDO;

class MySQLStockRepository implements StockRepository
{
    private Medoo $database;
    private QuoteRepository $quoteRepository;

    public function __construct(QuoteRepository $quoteRepository)
    {
        $this->database = new Medoo([
            'pdo' => new PDO('mysql:dbname=stock;host=localhost', 'root', 'kartupelis'),
            'database_type' => 'mysql'
        ]);
        $this->quoteRepository = $quoteRepository;
    }

    public function getQuote(string $stock): string
    {
        return $this->quoteRepository->getQuote($stock);
    }

    public function allStock(string $username): array
    {
        return $this->database->select('stock',
            ['stock_name',
                'stock_price_bought',
                'stock_amount',
                'stock_price_now',
                'active',
                'stock_sold',
                'id',
                'timestamp_buy',
                'timestamp_sold'],
            ['user_name' => $username]);
    }

    public function buy(string $username, string $stock, string $price, string $count): void
    {
        $this->database->insert('stock',
            ['user_name' => $username,
                'stock_name' => $stock,
                'stock_price_bought' => $price * 100,
                'stock_amount' => $count]);
    }

    public function sell(string $id, string $sellPrice): void
    {
        $this->database->update('stock',
            ['active' => false,
                'stock_sold' => $sellPrice,
                'timestamp_sold' => date('Y-m-d H:i:s', time() + 10800)],
            ['id' => $id]);
    }

    public function addCurrentPrice(string $userName): void
    {
        $stocks = $this->database->select('stock', 'stock_name',['user_name'=>$userName]);

        foreach ($stocks as $stock) {
            if ($this->database->has('stock', ['stock_name' => $stock, 'active' => true, 'user_name'=>$userName])) {
                $this->database->update('stock',
                    ['stock_price_now' => $this->getQuote($stock) * 100],
                    ['user_name' => $userName, 'stock_name' => $stock, 'active' => true]);
            }
        }
    }
}