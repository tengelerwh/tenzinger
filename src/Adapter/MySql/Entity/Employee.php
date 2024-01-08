<?php

namespace App\Adapter\MySql\Entity;

use App\Adapter\MySql\EmployeeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Employee as DomainEmployee;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    public ?string $guid = null;

    #[ORM\Column(type: Types::TEXT, length: 255)]
    public string $name;

    #[ORM\Column(type: Types::TEXT, length: 20)]
    public string $employeeId;

    public function getGuid(): ?string
    {
        return $this->guid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function fromDomain(DomainEmployee $domain): self
    {
        $employee = new self();
        $employee->employeeId = $domain->getId();
        $employee->name = $domain->getName();

        return $employee;
    }

    public function toDomain(): DomainEmployee
    {
        return new DomainEmployee($this->id, $this->name);
    }
}
