<?php

declare(strict_types=1);

namespace App\Application\Employee;

use App\Domain\Employee\Travel;

class TravelDto
{
    public function __construct(
        public readonly string $employeeId,
        public readonly string $name,
    ) {
    }

    public static function fromDomain(Travel $travel): self
    {
        // @todo implement Dto
        return new self($travel->getEmployeeId(), $travel->getTransport());
    }
}
