<?php

namespace App\Services;

use App\Entity\CryptoRate;
use App\Repository\CryptocurrencyRepository;
use App\Repository\CryptoRateRepository;
use App\Repository\CurrencyRepository;
use App\Request\GetRatesRequest;
use App\Response\RateListResponse;
use App\Response\RateResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CryptoRateService
{
    public function __construct(
        private readonly CryptoRateRepository $cryptoRateRepository,
        private readonly CurrencyRepository $currencyRepository,
        private readonly CryptocurrencyRepository $cryptocurrencyRepository,
    )
    {
    }

    /**
     * @param GetRatesRequest $getRatesRequest
     * @return RateListResponse
     */
    public function getCryptoRates(GetRatesRequest $getRatesRequest) : RateListResponse
    {
        $startTime = $getRatesRequest->getStartTime() ?? new \DateTime('@0');
        $endTime = $getRatesRequest->getEndTime() ?? new \DateTime();
        $limit = $getRatesRequest->getLimit();

        $currencies = $this->currencyRepository->findBy(['title' => $getRatesRequest->getCurrencies()]);
        $cryptocurrencies = $this->cryptocurrencyRepository->findBy(['title' => $getRatesRequest->getCryptocurrencies()]);

        $cryptoRates = $this->cryptoRateRepository
            ->getFiltered($startTime, $endTime, $currencies, $cryptocurrencies, $limit);

        $groupedRates = [];

        foreach ($cryptoRates as $cryptoRate) {
            $key = $cryptoRate->getCryptocurrency()->getTitle() . '/' . $cryptoRate->getCurrency()->getTitle();

            if (!isset($groupedRates[$key])) {
                $groupedRates[$key] = [];
            }

            $groupedRates[$key][] = new RateResponse($cryptoRate);
        }

        return new RateListResponse($groupedRates);
    }


}