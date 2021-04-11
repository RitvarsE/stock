<?php


namespace App\Repositories\Finnhub;

use Finnhub;
use GuzzleHttp;

class FinnhubRepository
{
    /**
     * @throws Finnhub\ApiException
     */
    public function getQuote(string $stock): Finnhub\Model\Quote
    {
        $config = Finnhub\Configuration::getDefaultConfiguration()->setApiKey('token', 'c1pj3v2ad3id1hoq2ap0');
        $client = new Finnhub\Api\DefaultApi(
            new GuzzleHttp\Client(),
            $config);
        return $client->quote($stock);
    }
}