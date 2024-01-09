<?php

namespace App\Adapter\MySql\Employee;

use App\Adapter\MySql\Employee\Entity\Employee;
use App\Adapter\MySql\Employee\Entity\CommuteCompensationEntityRepository;
use App\Adapter\MySql\Employee\Entity\CommuteCompensation as CommuteCompensationEntity;
use App\Adapter\MySql\Employee\Entity\EmployeeEntityRepository;
use App\Domain\Employee\CommuteCompensation;
use App\Domain\Employee\Employee as DomainEmployee;
use App\Domain\Employee\Port\EmployeeRepository as EmployeeRepositoryInterface;
use Psr\Log\LoggerInterface;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    public function __construct(
        private readonly EmployeeEntityRepository $employeeEntityRepository,
        private readonly CommuteCompensationEntityRepository $compensationEntityRepository,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * @return DomainEmployee[]
     */
    public function getEmployees(): array
    {
        $employees = $this->employeeEntityRepository->findAllEmployees();

        $result = [];
        /** @var Employee $employeeEntity */
        foreach($employees as $employeeEntity) {
            $result[] = $employeeEntity->toDomain();
        }

        return $result;
    }

    public function getCompensations(string $employeeId, ?int $year = null, ?int $month = null): array
    {
        $compensations = $this->compensationEntityRepository->getCompensations($employeeId, $year, $month);

        $result = [];
        /** @var CommuteCompensationEntity $compensationEntity */
        foreach($compensations as $compensationEntity) {
            $employee = $this->employeeEntityRepository->findById($compensationEntity->employeeId);
            $result[] = $compensationEntity->toDomain($employee?->name);
        }

        return $result;
    }

    public function storeCompensation(CommuteCompensation $compensation): void
    {
        $entity = CommuteCompensationEntity::fromDomain($compensation);
        $this->compensationEntityRepository->store($entity);
    }
}
