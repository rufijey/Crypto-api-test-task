<?php

namespace App\Services;

use App\Component\ImportBinanceDataClient;
use App\Entity\CryptoRate;
use App\Repository\CryptocurrencyRepository;
use App\Repository\CryptoRateRepository;
use App\Repository\CurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class LoadCryptoDataService
{
    private const LIMIT = 1000;

    /*
     * 2024-01-01 00:00:00 UTC
     */
    private const BASE_START_TIME = 1704067200000;

    public function __construct(
        private readonly ImportBinanceDataClient  $client,
        private readonly EntityManagerInterface   $entityManager,
        private readonly CurrencyRepository       $currencyRepository,
        private readonly CryptocurrencyRepository $cryptocurrencyRepository,
        private readonly CryptoRateRepository     $cryptoRateRepository
    )
    {
    }

    public function loadCryptoData(): void
    {
        $currentTime = round(microtime(true) * 1000);
        $currencies = $this->currencyRepository->findAll();
        $cryptocurrencies = $this->cryptocurrencyRepository->findAll();

        foreach ($cryptocurrencies as $cryptocurrency) {
            foreach ($currencies as $currency) {
                $startTime = $this->cryptoRateRepository
                    ->getLastTimestamp($cryptocurrency, $currency) ?? self::BASE_START_TIME;
                $this->loadPairData($cryptocurrency, $currency, $startTime, $currentTime);
            }
        }
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function loadDataToNewest(): void
    {
        $counter = 0;
        $batch = 5;

        $currentTime = round(microtime(true) * 1000);
        $currentHourTime = (new \DateTime())->setTimestamp((int)($currentTime / 1000))->format('Y-m-d H');

        $currencies = $this->currencyRepository->findAll();
        $cryptocurrencies = $this->cryptocurrencyRepository->findAll();

        foreach ($cryptocurrencies as &$cryptocurrency) {
            foreach ($currencies as &$currency) {

                $startTime = $this->cryptoRateRepository
                    ->getLastTimestamp($cryptocurrency, $currency) ?? self::BASE_START_TIME;
                $startHourTime = (new \DateTime())->setTimestamp((int)($startTime / 1000))->format('Y-m-d H');

                while ($currentHourTime > $startHourTime) {
                    if ($counter > 0 && $counter % $batch === 0) {
                        $this->entityManager->clear();
                    }
                    if ($counter >= $batch){
                        $cryptocurrency = $this->cryptocurrencyRepository->find($cryptocurrency);
                        $currency = $this->currencyRepository->find($currency);
                    }

                    $this->entityManager->flush();
                    $startTime = $this->cryptoRateRepository
                        ->getLastTimestamp($cryptocurrency, $currency) ?? self::BASE_START_TIME;
                    $startHourTime = (new \DateTime())->setTimestamp((int)($startTime / 1000))->format('Y-m-d H');

                    $this->loadPairData($cryptocurrency, $currency, $startTime, $currentTime);
                    $counter++;
                }
            }
        }
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    private function loadPairData($cryptocurrency, $currency, $startTime, $currentTime): void
    {
        $pair = $cryptocurrency->getSymbol() . $currency->getSymbol();
        $response = $this->client->getClient()->request(
            'GET',
            "klines?symbol=$pair&interval=1h&startTime=$startTime&endTime=$currentTime&limit=" . self::LIMIT
        );
        $cryptoRatesData = $response->toArray();
        foreach ($cryptoRatesData as $cryptoRateData) {

            $timestamp = (new \DateTime())
                ->setTimestamp((int)($cryptoRateData[0] / 1000));

            $cryptoRate = (new CryptoRate())
                ->setCryptocurrency($cryptocurrency)
                ->setCurrency($currency)
                ->setTimestamp($timestamp)
                ->setRate($cryptoRateData[4]);


            $this->entityManager->persist($cryptoRate);
        }
    }
}