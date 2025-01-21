<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
public function countByRole(string $role): int
{
    return $this->createQueryBuilder('u')
        ->select('COUNT(u.id)')
        ->andWhere('u.roleUser = :role')
        ->setParameter('role', $role)
        ->getQuery()
        ->getSingleScalarResult();
}
// UserRepository.php

public function averageSalariesByAgeGroup(): array
{
    // Define age brackets
    $ageBrackets = [
        '<20' => ['min' => 0, 'max' => 20],
        '20-30' => ['min' => 20, 'max' => 30],
        '31-40' => ['min' => 31, 'max' => 40],
        '41-50' => ['min' => 41, 'max' => 50],
        '>50' => ['min' => 51, 'max' => null],
    ];

    // Initialize array to store average salaries by age group
    $averageSalariesByAgeGroup = [];

    // Query to calculate average salary by age group
    foreach ($ageBrackets as $ageGroup => $ageRange) {
        $averageSalary = $this->createQueryBuilder('u')
            ->select('AVG(u.salaire) AS average_salary')
            ->andWhere('YEAR(CURRENT_DATE()) - YEAR(u.dateNaissance) BETWEEN :minAge AND :maxAge')
            ->setParameter('minAge', $ageRange['min'])
            ->setParameter('maxAge', $ageRange['max'])
            ->getQuery()
            ->getSingleScalarResult();

        // Store average salary for the age group
        $averageSalariesByAgeGroup[] = ['age_group' => $ageGroup, 'average_salary' => (float) $averageSalary];
    }

    return $averageSalariesByAgeGroup;
}

}
