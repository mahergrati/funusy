<?php

namespace App\Repository;

use App\Entity\Signale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Signale>
 *
 * @method Signale|null find($id, $lockMode = null, $lockVersion = null)
 * @method Signale|null findOneBy(array $criteria, array $orderBy = null)
 * @method Signale[]    findAll()
 * @method Signale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SignaleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Signale::class);
    }

//    /**
//     * @return Signale[] Returns an array of Signale objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Signale
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
