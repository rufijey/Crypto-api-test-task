<?php

namespace App\Component;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ImportBinanceDataClient
{
    private $client;
    public function __construct(HttpClientInterface $client){
        $this->client = $client->withOptions([
                'base_uri' => 'https://api.binance.com/api/v3/'
            ]);;
    }

    public function getClient(): HttpClientInterface
    {
        return $this->client;
    }

}