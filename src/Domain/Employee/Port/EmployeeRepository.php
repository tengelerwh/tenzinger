<?php

declare(strict_types=1);

namespace App\Domain\Employee\Port;

use App\Domain\Employee\CommuteCompensation;
use App\Domain\Employee\Employee;

interface EmployeeRepository
{
    /**
     * @return Employee[]
     */
    public function getEmployees(): array;

    /**
     * @return CommuteCompensation[]
     */
    public function getCompensations(string $employeeId, ?int $year = null, ?int $month = null): array;

    public function storeCompensation(CommuteCompensation $compensation): void;
}
