<?php

declare(strict_types=1);

namespace App\Domain\Transport;

class CompensationAmount
{
    public function __construct(
        private readonly TransportType $transportType,
        private readonly int $minDistance,
        private readonly ?int $maxDistance,
        private readonly float $amount,
    ) {
    }

    public function getTransportType(): TransportType
    {
        return $this->transportType;
    }

    public function getMinDistance(): int
    {
        return $this->minDistance;
    }

    public function getMaxDistance(): ?int
    {
        return $this->maxDistance;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
