<?php

namespace App\Response;

use App\Entity\CryptoRate;

class RateResponse
{
    private string $currency;
    private string $cryptocurrency;
    private float $rate;
    private \DateTime $dateTime;

    public function __construct(?CryptoRate $cryptoRate)
    {
        if (isset($cryptoRate)) {
            $this->currency = $cryptoRate->getCurrency()->getTitle();
            $this->cryptocurrency = $cryptoRate->getCryptocurrency()->getTitle();
            $this->rate = $cryptoRate->getRate();
            $this->dateTime = $cryptoRate->getTimestamp();
        }
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getCryptocurrency(): string
    {
        return $this->cryptocurrency;
    }

    public function setCryptocurrency(string $cryptocurrency): void
    {
        $this->cryptocurrency = $cryptocurrency;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTime $dateTime): void
    {
        $this->dateTime = $dateTime;
    }

}