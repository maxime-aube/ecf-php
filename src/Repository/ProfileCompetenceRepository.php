<?php

namespace App\Repository;

use App\Entity\ProfileCompetence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProfileCompetence|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfileCompetence|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfileCompetence[]    findAll()
 * @method ProfileCompetence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileCompetenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfileCompetence::class);
    }

    // /**
    //  * @return ProfileCompetence[] Returns an array of ProfileCompetence objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProfileCompetence
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
