<?php

declare(strict_types=1);

namespace App\Application\Employee;

use App\Domain\Employee\Employee;

class EmployeeDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
    ) {
    }

    public static function fromDomain(Employee $employee): self
    {
        return new self($employee->getId(), $employee->getName());
    }
}
