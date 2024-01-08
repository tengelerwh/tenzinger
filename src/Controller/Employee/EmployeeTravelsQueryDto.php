<?php

declare(strict_types=1);

namespace App\Controller\Employee;

use Symfony\Component\Validator\Constraints as Assert;

class EmployeeTravelsQueryDto
{
    public function __construct(

        #[Assert\NotBlank]
        #[Assert\NoSuspiciousCharacters]
        public readonly string $employeeId,

        #[Assert\Choice(['html', 'csv'])]
        public readonly string $format = 'html',
    ) {
    }
}
