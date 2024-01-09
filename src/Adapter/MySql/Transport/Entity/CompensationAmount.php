<?php

namespace App\Adapter\MySql\Transport\Entity;

use App\Domain\Transport\CompensationAmount as DomainCompensationAmount;
use App\Domain\Transport\TransportType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompensationAmountEntityRepository::class)]
class CompensationAmount
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    public ?string $guid = null;

    #[ORM\Column(type: Types::TEXT, length: 15)]
    public string $transportType;

    #[ORM\Column(type: Types::INTEGER)]
    public int $minDistance;

    #[ORM\Column(type: Types::INTEGER)]
    public ?int $maxDistance;

    #[ORM\Column(type: Types::FLOAT)]
    public float $amount;


    public static function fromDomain(DomainCompensationAmount $domain): self
    {
        $compensationAmount = new self();
        $compensationAmount->transportType = $domain->getTransportType()->value;
        $compensationAmount->minDistance = $domain->getMinDistance();
        $compensationAmount->maxDistance = $domain->getMaxDistance();
        $compensationAmount->amount = $domain->getAmount();

        return $compensationAmount;
    }

    public function toDomain(): DomainCompensationAmount
    {

        return new DomainCompensationAmount(
            TransportType::tryFrom($this->transportType),
            $this->minDistance,
            $this->maxDistance,
            $this->amount,
        );
    }
}
