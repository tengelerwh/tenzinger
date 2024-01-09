<?php

declare(strict_types=1);

namespace App\Domain\Employee;

use App\Domain\Transport\TransportType;

class Employee
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly TransportType $transportType,
        private readonly int $commuteDistance,
        private readonly float $workDaysPerWeek,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTransportType(): TransportType
    {
        return $this->transportType;
    }

    public function getCommuteDistance(): int
    {
        return $this->commuteDistance;
    }

    public function getWorkDaysPerWeek(): float
    {
        return $this->workDaysPerWeek;
    }
}
