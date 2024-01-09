<?php

declare(strict_types=1);

namespace App\Domain\Employee;

use App\Domain\Transport\CompensationAmount;
use App\Domain\Transport\TransportType;
use DateInterval;
use DatePeriod;
use DateTimeImmutable;
use DateTimeInterface;

class CommuteCompensation
{
    public function __construct(
        private readonly string $employeeId,
        private readonly string $name,
        private readonly int $year,
        private readonly int $month,
        private readonly TransportType $transportType,
        private readonly int $totalDistance,
        private readonly int $workDays,
        private readonly float $amount,
    ) {
    }

    public function getEmployeeId(): string
    {
        return $this->employeeId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function getMonth(): int
    {
        return $this->month;
    }

    public function getTransportType(): TransportType
    {
        return $this->transportType;
    }

    public function getTotalDistance(): int
    {
        return $this->totalDistance;
    }

    public function getWorkDays(): int
    {
        return $this->workDays;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public static function calculateCompensation(
        CompensationAmount $compensationAmount,
        Employee $employee,
        int $year,
        int $month,
    ): self
    {
        $startDate = new DateTimeImmutable(sprintf('%04d-%02d-01T00:00:00+00:00', $year, $month));
        $endDate = $startDate->add(new DateInterval('P1M'));
        $period = new DatePeriod($startDate, new DateInterval('P1D'), $endDate);

        $weeks = 0;
        /** @var DateTimeInterface $day */
        foreach($period as $day) {
            $weekday = (int) $day->format('w');
            // pick monday to calculate number of weeks
            if ($weekday === 1) {
                $weeks++;
            }
        }

        $workingDays = $weeks * (int) ceil($employee->getWorkDaysPerWeek());
        $totalDistance = $workingDays * $employee->getCommuteDistance() * 2;
        $amount = $totalDistance * $compensationAmount->getAmount();

        return new self(
            $employee->getId(),
            $employee->getName(),
            $year,
            $month,
            $employee->getTransportType(),
            (int) $totalDistance,
            (int) $workingDays,
            $amount,
        );
    }
}
