<?php


namespace App\Repositories\Stock;


interface StockRepository
{
    public function allStock(string $username): array;

    public function buy(string $username, string $stock, string $price, string $count): void;

    public function sell(string $id, string $sellPrice): void;

    public function addCurrentPrice(string $userName): void;
}