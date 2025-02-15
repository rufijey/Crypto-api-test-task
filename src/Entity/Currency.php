<?php

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
class Currency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 120, nullable: true)]
    private ?string $symbol = null;

    #[ORM\OneToMany(targetEntity: CryptoRate::class, mappedBy: 'currencies', cascade: ['persist', 'remove'])]
    private Collection $cryptoRates;

    public function __construct()
    {
        $this->cryptoRates = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(?string $symbol): self

    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getCryptoRates(): Collection
    {
        return $this->cryptoRates;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }
}
