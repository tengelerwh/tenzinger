<?php

namespace App\Domain\Transport;

enum TransportType: string
{
    case CAR = 'car';
    case BUS = 'bus';
    case BIKE = 'bike';
    case TRAIN = 'train';

    public function getDisplayName(): string
    {
        return match($this) {
            self::CAR => 'Car',
            self::BUS => 'Bus',
            self::BIKE => 'Bike',
            self::TRAIN => 'Train',
        };
    }
}
