<?php

declare(strict_types=1);

namespace App\Application\Employee;

use App\Domain\Employee\Employee;
use App\Domain\Employee\Port\EmployeeRepository;
use App\Domain\Employee\Port\TravelRepository;

class EmployeeService
{
    public function __construct(
        private readonly EmployeeRepository $employeeRepository,
        private readonly TravelRepository $travelRepository,
    )
    {

    }
    /**
     * @return EmployeeDto[]
     */
    public function getEmployees(): array
    {
        $employees = $this->employeeRepository->getEmployees();

        $result = [];

        foreach($employees as $employeeEntity) {
            $result[] = EmployeeDto::fromDomain($employeeEntity);
        }
        return $result;
//            [
//            '0001' => EmployeeDto::fromDomain(new Employee('0001', 'Paul')),
//            '0002' => EmployeeDto::fromDomain(new Employee('0002', 'Martin')),
//            '0003' => EmployeeDto::fromDomain(new Employee('0003', 'Jeroen')),
//            '0004' => EmployeeDto::fromDomain(new Employee('0004', 'Tineke')),
//            '0005' => EmployeeDto::fromDomain(new Employee('0005', 'Arnout')),
//            '0006' => EmployeeDto::fromDomain(new Employee('0006', 'Matthijs')),
//            '0007' => EmployeeDto::fromDomain(new Employee('0007', 'Rens')),
//            '0008' => EmployeeDto::fromDomain(new Employee('0008', 'Ahmed')),
//        ];
    }

    /**
     * @return TravelDto[]
     */
    public function getTravels(string $employeeId): array
    {

    }
}
