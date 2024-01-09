<?php

namespace App\Adapter\MySql\Employee\Entity;

use App\Domain\Employee\CommuteCompensation as DomainCommuteCompensation;
use App\Domain\Transport\TransportType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommuteCompensationEntityRepository::class)]
class CommuteCompensation
{
    #[ORM\Id]
    #[ORM\Column(type: Types::GUID, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    public ?string $guid = null;

    #[ORM\Column(type: Types::TEXT, length: 20)]
    public string $employeeId;

    #[ORM\Column(type: Types::INTEGER)]
    public int $year;

    #[ORM\Column(type: Types::INTEGER)]
    public int $month;

    #[ORM\Column(type: Types::TEXT, length: 15)]
    public string $transportType;

    #[ORM\Column(type: Types::INTEGER)]
    public int $nrOfDays;

    #[ORM\Column(type: Types::INTEGER)]
    public int $totalDistance;

    #[ORM\Column(type: Types::FLOAT)]
    public float $compensationAmount;

    public function toDomain(?string $name): DomainCommuteCompensation
    {
        return new DomainCommuteCompensation(
            $this->employeeId,
            $name,
            $this->year,
            $this->month,
            TransportType::tryFrom($this->transportType),
            $this->totalDistance,
            $this->nrOfDays,
            $this->compensationAmount,
        );
    }

    public static function fromDomain(DomainCommuteCompensation $compensation): self
    {
        $entity =  new self();
        $entity->employeeId = $compensation->getEmployeeId();
        $entity->year = $compensation->getYear();
        $entity->month = $compensation->getMonth();
        $entity->transportType = $compensation->getTransportType()->value;
        $entity->totalDistance = $compensation->getTotalDistance();
        $entity->nrOfDays = $compensation->getWorkDays();
        $entity->compensationAmount = $compensation->getAmount();

        return $entity;
    }
}
