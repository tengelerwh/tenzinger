<?php

namespace App\Adapter\MySql;

use App\Adapter\MySql\Entity\Employee;
use App\Domain\Employee\Employee as DomainEmployee;
use App\Domain\Employee\Port\EmployeeRepository as EmployeeRepositoryInterface;
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
class EmployeeRepository extends ServiceEntityRepository implements EmployeeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * @return DomainEmployee[]
     */
    public function getEmployees(): array
    {
        $employees = $this->findAllEmployees();

        $result = [];
        /** @var Employee $employeeEntity */
        foreach($employees as $employeeEntity) {
            $result[] = $employeeEntity->toDomain();
        }

        return $result;
    }

    private function findAllEmployees(): array
    {
        return $this->createQueryBuilder('emp')
            ->orderBy('emp.employeeId', 'ASC')
            ->getQuery()
            ->getResult();
    }


//    /**
//     * @return Employee[] Returns an array of Employee objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Employee
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
