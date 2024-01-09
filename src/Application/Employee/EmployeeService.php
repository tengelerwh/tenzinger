<?php

declare(strict_types=1);

namespace App\Application\Employee;

use App\Domain\Employee\CommuteCompensation;
use App\Domain\Employee\Employee;
use App\Domain\Employee\Port\EmployeeRepository;
use App\Domain\Transport\CompensationAmount;
use App\Domain\Transport\Exception\CompensationException;
use App\Domain\Transport\Port\TransportRepository;
use Psr\Log\LoggerInterface;

class EmployeeService
{
    public function __construct(
        private readonly EmployeeRepository $employeeRepository,
        private readonly TransportRepository $transportRepository,
        private readonly LoggerInterface $logger,
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

        foreach($employees as $employee) {
            $result[] = EmployeeDto::fromDomain($employee);
        }
        return $result;
    }

    /**
     * @return CompensationDto[]
     */
    public function getCompensations(string $employeeId, int $year, ?int $month): array
    {
        $compensations = $this->employeeRepository->getCompensations($employeeId, $year, $month);
        $result = [];

        foreach($compensations as $compensation) {
            $result[] = CompensationDto::fromDomain($compensation);
        }

        $this->logger->debug(sprintf('EmployeeService::getCompensations: %s ', print_r($result, true)));
        return $result;
    }

    public function calculateCompensations(?string $employeeId, int $year, int $month): int
    {
        $employees = $this->employeeRepository->getEmployees();

        $calculated = 0;
        foreach($employees as $employee) {
            try {
                $compensationAmount = $this->getCompensationAmountForEmployee($employee);
                if (null === $compensationAmount) {
                    throw new CompensationException(sprintf('Cannot find compensation amount for employee %s', $employee->getName()));
                }
                $compensation = CommuteCompensation::calculateCompensation($compensationAmount, $employee, $year, $month);
                $this->employeeRepository->storeCompensation($compensation);
                $calculated++;
            } catch (CompensationException $exception) {
                $this->logger->warning(
                    sprintf('Employee %s: year: %4d, month: %2d - %s', $employee->getName(), $year, $month, $exception->getMessage())
                );
            }
        }

        return $calculated;
    }

    private function getCompensationAmountForEmployee(Employee $employee): ?CompensationAmount
    {
        return $this->transportRepository->getCompensation($employee->getTransportType(), $employee->getCommuteDistance());
    }
}
