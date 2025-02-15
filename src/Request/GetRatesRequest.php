<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints as Assert;

class GetRatesRequest
{
    #[Assert\Type(type: "\DateTime", message: "Start time must be a valid DateTime object.")]
    private ?\DateTime $startTime = null;

    #[Assert\Type(type: "\DateTime", message: "End time must be a valid DateTime object.")]
    #[Assert\GreaterThan(propertyPath: "startTime", message: "End time must be greater than start time.")]
    private ?\DateTime $endTime = null;

    #[Assert\Type(type: "integer", message: "Limit must be an integer.")]
    #[Assert\GreaterThanOrEqual(value: 1, message: "Limit must be greater than or equal to 1.")]
    private ?int $limit = null;

    private array $currencies = [];
    private array $cryptocurrencies = [];

    public function getStartTime(): ?\DateTime
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTime|string $startTime): self
    {
        if (is_string($startTime)) {
            $this->startTime = \DateTime::createFromFormat(\DateTime::ATOM, $startTime) ?: null;
        } elseif ($startTime instanceof \DateTime) {
            $this->startTime = $startTime;
        }

        return $this;
    }

    public function getEndTime(): ?\DateTime
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTime|string $endTime): self
    {
        if (is_string($endTime)) {
            $this->endTime = \DateTime::createFromFormat(\DateTime::ATOM, $endTime) ?: null;
        } elseif ($endTime instanceof \DateTime) {
            $this->endTime = $endTime;
        }

        return $this;
    }

    public function getLimit(): ?int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function getCurrencies(): array
    {
        return $this->currencies;
    }

    public function setCurrencies(array|string|null $currencies): self
    {
        if (is_string($currencies)) {
            $this->currencies = array_filter(array_map('trim', explode(',', $currencies)));
        } elseif (is_array($currencies)) {
            $this->currencies = $currencies;
        }

        return $this;
    }

    public function getCryptocurrencies(): array
    {
        return $this->cryptocurrencies;
    }

    public function setCryptocurrencies(array|string|null $cryptocurrencies): self
    {
        if (is_string($cryptocurrencies)) {
            $this->cryptocurrencies = array_filter(array_map('trim', explode(',', $cryptocurrencies)));
        } elseif (is_array($cryptocurrencies)) {
            $this->cryptocurrencies = $cryptocurrencies;
        }

        return $this;
    }
}
