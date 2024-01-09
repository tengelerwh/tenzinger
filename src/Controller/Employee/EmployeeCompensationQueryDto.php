<?php

declare(strict_types=1);

namespace App\Controller\Employee;

use Symfony\Component\Validator\Constraints as Assert;

class EmployeeCompensationQueryDto
{
    public function __construct(

        #[Assert\NotBlank]
        #[Assert\NoSuspiciousCharacters]
        public readonly string $employeeId,

        #[Assert\NotBlank]
        #[Assert\Positive]
        public readonly string $year,

        #[Assert\Range(
            notInRangeMessage: 'Month must be a valid month (1 -12)',
            min: 1,
            max: 12,
        )]
        public readonly ?string $month = '1',

        #[Assert\Choice(['html', 'csv'])]
        public readonly ?string $format = 'csv',
    ) {
    }
}
