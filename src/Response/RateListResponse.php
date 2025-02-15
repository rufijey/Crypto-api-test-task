<?php

namespace App\Response;

class RateListResponse
{
    private array $groupedRates;

    public function __construct(?array $groupedRates)
    {
        $this->groupedRates = $groupedRates;
    }

    public function getGroupedRates(): array
    {
        return $this->groupedRates;
    }

    public function setGroupedRates(array $groupedRates): void
    {
        $this->groupedRates = $groupedRates;
    }
}