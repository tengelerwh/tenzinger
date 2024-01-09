<?php

declare(strict_types=1);

namespace App\Tests\Domain\Transport;

use App\Domain\Transport\TransportType;
use PHPUnit\Framework\TestCase;

class TransportTypeTest extends TestCase
{
    /**
     * @dataProvider transportTypeProvider
     */
    public function testGetDisplayName(TransportType $type, string $expected): void
    {
        $this->assertSame($expected, $type->getDisplayName());
    }

    public function transportTypeProvider(): array
    {
        return [
            'car' => [TransportType::CAR, 'Car'],
            'bus' => [TransportType::BUS, 'Bus'],
            'bike' => [TransportType::BIKE, 'Bike'],
            'train' => [TransportType::TRAIN, 'Train'],
        ];
    }
}
