<?php

namespace App\Entity;

use App\Repository\CryptoRateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CryptoRateRepository::class)]
class CryptoRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Cryptocurrency::class, inversedBy: 'crypto_rates')]
    private ?Cryptocurrency $cryptocurrency = null;

    #[ORM\ManyToOne(targetEntity: Currency::class, inversedBy: 'crypto_rates')]
    private ?Currency $currency = null;

    #[ORM\Column]
    private ?float $rate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $timestamp = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function setRate(float $rate): self
    {
        $this->rate = $rate;
        return $this;
    }

    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTime $timestamp): self
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function getCryptocurrency(): ?Cryptocurrency
    {
        return $this->cryptocurrency;
    }

    public function setCryptocurrency(?Cryptocurrency $cryptocurrency): self
    {
        $this->cryptocurrency = $cryptocurrency;
        return $this;
    }

}
