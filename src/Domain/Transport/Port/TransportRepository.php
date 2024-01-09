<?php

declare(strict_types=1);

namespace App\Domain\Transport\Port;

use App\Domain\Employee\CommuteCompensation;
use App\Domain\Employee\Employee;
use App\Domain\Transport\CompensationAmount;
use App\Domain\Transport\TransportType;

interface TransportRepository
{
    public function getCompensation(TransportType $transportType, int $distance): ?CompensationAmount;
}
