<?php

namespace App\Adapter\MySql\Employee\Entity;

use App\Domain\Employee\Employee as DomainEmployee;
use App\Domain\Transport\TransportType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeEntityRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    public ?string $guid = null;

    #[ORM\Column(type: Types::TEXT, length: 20)]
    public string $employeeId;

    #[ORM\Column(type: Types::TEXT, length: 255)]
    public string $name;

    #[ORM\Column(type: Types::TEXT, length: 15)]
    public string $transportType;

    #[ORM\Column(type: Types::INTEGER)]
    public int $commuteDistance;

    #[ORM\Column(type: Types::FLOAT)]
    public float $workDaysPerWeek;


    public static function fromDomain(DomainEmployee $domain): self
    {
        $employee = new self();
        $employee->employeeId = $domain->getId();
        $employee->name = $domain->getName();
        $employee->transportType = $domain->getTransportType()->value;
        $employee->commuteDistance = $domain->getCommuteDistance();
        $employee->workDaysPerWeek = $domain->getWorkDaysPerWeek();

        return $employee;
    }

    public function toDomain(): DomainEmployee
    {

        return new DomainEmployee(
            $this->employeeId,
            $this->name,
            TransportType::tryFrom($this->transportType),
            $this->commuteDistance,
            $this->workDaysPerWeek,
        );
    }
}
