<?php

namespace App\Adapter\MySql\Employee\Entity;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<\App\Adapter\MySql\Employee\Entity\CommuteCompensation>
 *
 * @method CommuteCompensation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommuteCompensation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommuteCompensation[]    findAll()
 * @method CommuteCompensation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommuteCompensationEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommuteCompensation::class);
    }

    public function getCompensations(string $employeeId, ?int $year = null, ?int $month = null): array
    {

        $query = $this->createQueryBuilder('comp')
            ->orderBy('comp.year, comp.month', 'ASC');

        if ('all' !== $employeeId) {
            $query->andWhere('comp.employeeId = :employeeId')
            ->setParameter('employeeId', $employeeId);
        }

        if (null !== $year) {
            $query->andWhere('comp.year = :year')
            ->setParameter('year', $year);
        }
        if (null !== $month) {
            $query->andWhere('comp.month = :month')
            ->setParameter('month', $month);
        }

        return $query->getQuery()->getResult();
    }

    public function store(CommuteCompensation $entity): void
    {
        $manager = $this->getEntityManager();
        $manager->persist($entity);
        $manager->flush();
    }
}
