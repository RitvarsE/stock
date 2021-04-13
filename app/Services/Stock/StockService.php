<?php


namespace App\Services\Stock;


use App\Repositories\Stock\StockRepository;

class StockService
{
    private StockRepository $stockRepository;

    public function __construct(StockRepository $stockRepository)
    {
        $this->stockRepository = $stockRepository;
    }

    public function allStock(string $username): array
    {
        return $this->stockRepository->allStock($username);
    }

    public function buy(string $username, string $stock, string $price, string $count): void
    {
        $this->stockRepository->buy($username, $stock, $price, $count);
    }

    public function sell(string $id, string $stockPrice): void
    {
        $this->stockRepository->sell($id, $stockPrice);
    }

    public function addCurrentPrice(string $userName): void
    {
        $this->stockRepository->addCurrentPrice($userName);
    }
}