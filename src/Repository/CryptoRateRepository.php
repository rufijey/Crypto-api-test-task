<?php

namespace App\Repository;

use App\Entity\Cryptocurrency;
use App\Entity\CryptoRate;
use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CryptoRate>
 */
class CryptoRateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CryptoRate::class);
    }

    /**
     * @param Cryptocurrency $cryptocurrency
     * @param Currency $currency
     * @return int|null
     * @throws \DateMalformedStringException
     */
    public function getLastTimestamp(Cryptocurrency $cryptocurrency, Currency $currency): int|null
    {
        $result = $this->createQueryBuilder('cr')
            ->select('MAX(cr.timestamp) AS lastTimestamp')
            ->where('cr.cryptocurrency = :crypto')
            ->andWhere('cr.currency = :currency')
            ->setParameter('crypto', $cryptocurrency)
            ->setParameter('currency', $currency)
            ->getQuery()
            ->getSingleScalarResult();

        return $result ? (new \DateTime($result))->getTimestamp() * 1000 + 1 : null;
    }


    /**
     * @param \DateTime $startTimestamp
     * @param \DateTime $endTimestamp
     * @param array|null $currencies
     * @param array|null $cryptocurrencies
     * @param int|null $limit
     * @return array<CryptoRate>
     */
    public function getFiltered(
        \DateTime $startTimestamp,
        \DateTime $endTimestamp,
        ?array $currencies = null,
        ?array $cryptocurrencies = null,
        ?int $limit = null
    ): array
    {
        $queryBuilder = $this->createQueryBuilder('cr')
            ->select('cr')
            ->where('cr.timestamp BETWEEN :startTimestamp AND :endTimestamp')
            ->setParameter('startTimestamp', $startTimestamp)
            ->setParameter('endTimestamp', $endTimestamp);

        if (!empty($currencies)) {
            $queryBuilder->andWhere('cr.currency IN (:currencies)')
                ->setParameter('currencies', $currencies);
        }

        if (!empty($cryptocurrencies)) {
            $queryBuilder->andWhere('cr.cryptocurrency IN (:cryptocurrencies)')
                ->setParameter('cryptocurrencies', $cryptocurrencies);
        }

        if (isset($limit)) {
            $queryBuilder->setMaxResults($limit);
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
