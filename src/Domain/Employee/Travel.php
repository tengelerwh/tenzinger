<?php

declare(strict_types=1);

namespace App\Domain\Employee;

class Travel
{
    public function __construct(
        private readonly string $employeeId,
        private readonly int $year,
        private readonly int $week,
        private readonly string $transport,
        private readonly int $distance,
        private readonly int $workDays,
    ) {
    }

    public function getEmployeeId(): string
    {
        return $this->employeeId;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getWeek(): int
    {
        return $this->week;
    }

    public function getTransport(): string
    {
        return $this->transport;
    }

    public function getDistance(): int
    {
        return $this->distance;
    }

    public function getWorkDays(): int
    {
        return $this->workDays;
    }
}
