<?php

declare(strict_types=1);

namespace App\Adapter\MySql\Transport;

use App\Adapter\MySql\Transport\Entity\CompensationAmountEntityRepository;
use App\Domain\Transport\CompensationAmount;
use App\Domain\Transport\Port\TransportRepository as TransportRepositoryInterface;
use App\Domain\Transport\TransportType;

class TransportRepository implements TransportRepositoryInterface
{
    public function __construct(
        private readonly CompensationAmountEntityRepository $amountEntityRepository
    ) {
    }

    public function getCompensation(TransportType $transportType, int $distance): ?CompensationAmount
    {
        $entity = $this->amountEntityRepository->getCompensation($transportType->value, $distance);
        if (null === $entity) {
            return null;
        }

        return $entity->toDomain();
    }
}
