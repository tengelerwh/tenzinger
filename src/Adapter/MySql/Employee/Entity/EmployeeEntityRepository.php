<?php

namespace App\Adapter\MySql\Employee\Entity;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 *
 * @method Employee|null find($id, $lockMode = null, $lockVersion = null)
 * @method Employee|null findOneBy(array $criteria, array $orderBy = null)
 * @method Employee[]    findAll()
 * @method Employee[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmployeeEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * @return Employee[]
     */
    public function findAllEmployees(): array
    {
        return $this->createQueryBuilder('e')
            ->orderBy('e.employeeId', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findById(string $value): ?Employee
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.employeeId = :employeeId')
            ->setParameter('employeeId', $value)
            ->getQuery()
            ->getSingleResult();
    }
}
