<?php

declare(strict_types=1);

namespace App\Domain\Employee\Port;

use App\Domain\Employee\Employee;

interface EmployeeRepository
{
    /**
     * @return Employee[]
     */
    public function getEmployees(): array;
}
