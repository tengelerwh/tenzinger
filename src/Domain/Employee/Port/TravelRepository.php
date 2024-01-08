<?php

declare(strict_types=1);

namespace App\Domain\Employee\Port;

use App\Domain\Employee\Travel;

interface TravelRepository
{
    /**
     * @return Travel[]
     */
    public function getTravels(string $employeeId, ?int $year = null, ?int $week = null): array;
}
