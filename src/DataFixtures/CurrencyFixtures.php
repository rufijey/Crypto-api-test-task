<?php

namespace App\DataFixtures;

use App\Entity\Cryptocurrency;
use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $currency = (new Currency())->setTitle('USD')->setSymbol('USDT');
        $manager->persist($currency);

        $currency = (new Currency())->setTitle('EUR')->setSymbol('EUR');
        $manager->persist($currency);

        $currency = (new Currency())->setTitle('UAH')->setSymbol('UAH');
        $manager->persist($currency);

        $cryptoCurrency = (new CryptoCurrency())->setTitle('BTC')->setSymbol('BTC');
        $manager->persist($cryptoCurrency);

        $manager->flush();
    }
}
