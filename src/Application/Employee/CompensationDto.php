<?php

declare(strict_types=1);

namespace App\Application\Employee;

use App\Domain\Employee\CommuteCompensation;

class CompensationDto
{
    public function __construct(
        public readonly string $employeeId,
        public readonly string $name,
        public readonly int $year,
        public readonly int $month,
        public readonly string $transport,
        public readonly int $totalDistance,
        public readonly int $workDays,
        public readonly float $amount,
    ) {
    }

    public static function fromDomain(CommuteCompensation $compensation, string $name = 'Paul'): self
    {
        return new self(
            $compensation->getEmployeeId(),
            $compensation->getName(),
            $compensation->getYear(),
            $compensation->getMonth(),
            $compensation->getTransportType()->getDisplayName(),
            $compensation->getTotalDistance(),
            $compensation->getWorkDays(),
            $compensation->getAmount()
        );
    }
}
