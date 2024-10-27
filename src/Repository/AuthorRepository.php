<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{

       //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function getAuthorOrderByName()
    {
        $em = $this->getEntityManager(); // Added missing semicolon
        $query = $em->createQuery('SELECT a FROM App\Entity\Author a ORDER BY a.name ASC'); // Fixed query alias
        return $query->getResult();
    }

    public function getAuthorByName($n)
    {
        $em = $this->getEntityManager(); // Added missing semicolon
        $query = $em->createQuery('SELECT a FROM App\Entity\Author a WHERE a.email = :email'); // Fixed query alias and condition
        $query->setParameter('email', $n); // Corrected parameter syntax
        return $query->getResult();
    }
}
