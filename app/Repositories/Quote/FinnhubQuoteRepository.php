<?php


namespace App\Repositories\Quote;


use Doctrine\Common\Cache\Cache;

class FinnhubQuoteRepository implements QuoteRepository
{
    private Cache $cache;

    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    public function getQuote(string $stock): string
    {
        $stockPrice = 'stock_' . $stock;
        if ($this->cache->contains($stockPrice)) {
            return $this->cache->fetch($stockPrice);
        }
        $this->cache->save($stockPrice, json_decode(
            file_get_contents(
                'https://finnhub.io/api/v1/quote?symbol=' . $stock . '&token=c1pj3v2ad3id1hoq2ap0')
            , true)['c'], 300);

        return json_decode(
            file_get_contents(
                'https://finnhub.io/api/v1/quote?symbol=' . $stock . '&token=c1pj3v2ad3id1hoq2ap0')
            , true)['c'];
    }
}