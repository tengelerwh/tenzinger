<?php

namespace App\Adapter\MySql\Transport\Entity;

use App\Adapter\MySql\Employee\Entity\CommuteCompensation;
use App\Domain\Transport\TransportType;
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
class CompensationAmountEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompensationAmount::class);
    }

    public function getCompensation(string $transportType, int $distance): ?CompensationAmount
    {
        $query = $this->createQueryBuilder('am')
            ->where('am.transportType = :transportType')
            ->setParameter('transportType', $transportType)
            ->andWhere('am.minDistance <= :distance')
            ->setParameter('distance', $distance);

        $orX = $query->expr()->orX();
        $orX->add($query->expr()->gt('am.maxDistance', ':distance'));
        $orX->add($query->expr()->isNull('am.maxDistance'));

        $query->andWhere($orX)
            ->setParameter('distance', $distance);

        return $query->getQuery()->getSingleResult();
    }

//    /**
//     * @return Travel[] Returns an array of Travel objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Travel
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

}
