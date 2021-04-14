<?php


namespace App\Repositories\Quote;


interface QuoteRepository
{
    public function getQuote(string $stock): string;
}