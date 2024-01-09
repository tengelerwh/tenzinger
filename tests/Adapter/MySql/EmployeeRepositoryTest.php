<?php

declare(strict_types=1);

namespace App\Tests\Adapter\MySql;

use App\Adapter\MySql\Employee\EmployeeRepository;
use App\Adapter\MySql\Employee\Entity\CommuteCompensation;
use App\Adapter\MySql\Employee\Entity\Employee;
use App\Adapter\MySql\Employee\Entity\CommuteCompensationEntityRepository;
use App\Adapter\MySql\Employee\Entity\EmployeeEntityRepository;
use App\Domain\Employee\CommuteCompensation as DomainCommuteCompensation;
use App\Domain\Employee\Employee as DomainEmployee;
use App\Domain\Transport\TransportType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class EmployeeRepositoryTest extends TestCase
{

    private EmployeeRepository $repository;

    private EmployeeEntityRepository|MockObject $employeeEntityRepository;
    private CommuteCompensationEntityRepository|MockObject $compensationEntityRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->employeeEntityRepository = $this->createMock(EmployeeEntityRepository::class);
        $this->compensationEntityRepository = $this->createMock(CommuteCompensationEntityRepository::class);
        $this->repository = new EmployeeRepository(
            $this->employeeEntityRepository,
            $this->compensationEntityRepository,
        );
    }

    public function testGetEmployeesWillReturnDomainEmployees()
    {
        $entities = [];
        $employee = new Employee();
        $employee->guid = null;
        $employee->employeeId = '0001';
        $employee->name = 'Henk';
        $employee->workDaysPerWeek = 3.5;
        $employee->transportType = TransportType::CAR->value;
        $employee->commuteDistance = 15;
        $entities[] = $employee;

        $employee = new Employee();
        $employee->guid = '620c7c1e-7140-4ccb-9f1f-9b598431403f';
        $employee->employeeId = '0004';
        $employee->name = 'Tineke';
        $employee->workDaysPerWeek = 5;
        $employee->transportType = TransportType::BIKE->value;
        $employee->commuteDistance = 8;
        $entities[] = $employee;

        $this->employeeEntityRepository->expects(self::once())
            ->method('findAllEmployees')
            ->willReturn($entities);

        $employees = $this->repository->getEmployees();
        $this->assertIsArray($employees);
        $this->assertCount(2, $employees);
        $employee1 = $employees[0];
        $this->assertInstanceOf(DomainEmployee::class, $employee1);
        $this->assertSame('0001', $employee1->getId());
        $this->assertSame('Henk', $employee1->getName());
        $this->assertSame(TransportType::CAR->value, $employee1->getTransportType()->value);
        $this->assertSame(3.5, $employee1->getWorkDaysPerWeek());
        $this->assertSame(15, $employee1->getCommuteDistance());
    }

    public function testGetCompensationsWithYearAndMonthWillReturnOneCompensation(): void
    {
        $compensation = new CommuteCompensation();
        $compensation->guid = '879b53f1-36d2-4d81-810f-05e0ac9cc720';
        $compensation->employeeId = '0001';
        $compensation->year = 2024;
        $compensation->month = 1;
        $compensation->transportType = TransportType::CAR->value;
        $compensation->nrOfDays = 15;
        $compensation->totalDistance = 15 * 2;
        $amount = 0.1 * $compensation->totalDistance * $compensation->nrOfDays;
        $compensation->compensationAmount = $amount;

        $this->compensationEntityRepository->expects(self::once())
           ->method('getCompensations')
           ->willReturn([$compensation]);

        $compensations = $this->repository->getCompensations('0001', 2024, 1);

        $this->assertIsArray($compensations);
        $this->assertCount(1, $compensations);
        $this->assertInstanceOf(DomainCommuteCompensation::class, $compensations[0]);
        $this->assertSame('0001', $compensations[0]->getEmployeeId());
        $this->assertSame(2024, $compensations[0]->getYear());
        $this->assertSame(1, $compensations[0]->getMonth());
        $this->assertSame(TransportType::CAR->value, $compensations[0]->getTransportType()->value);
        $this->assertSame(15, $compensations[0]->getWorkDays());
        $this->assertSame($amount, $compensations[0]->getAmount());
        $this->assertSame(30, $compensations[0]->getTotalDistance());
    }

    private function setupCompensationEntities(): array
    {
        $entities = [];
        $compensation = new CommuteCompensation();
        $compensation->guid = '879b53f1-36d2-4d81-810f-05e0ac9cc720';
        $compensation->employeeId = '0001';
        $compensation->year = 2024;
        $compensation->month = 1;
        $compensation->nrOfDays = 15;
        $compensation->compensationAmount = 0.1 * 15 * 2 * $compensation->nrOfDays;
        $entities[] = $compensation;

        $compensation = new CommuteCompensation();
        $compensation->guid = '879b53f1-36d2-4d81-810f-05e0ac9cc720';
        $compensation->employeeId = '0001';
        $compensation->year = 2024;
        $compensation->month = 2;
        $compensation->nrOfDays = 13;
        $compensation->compensationAmount = 0.1 * 15 * 2 * $compensation->nrOfDays;
        $entities[] = $compensation;
    }
}
