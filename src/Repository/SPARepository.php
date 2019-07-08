<?php

namespace App\Repository;

use App\Entity\SPA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method SPA|null find($id, $lockMode = null, $lockVersion = null)
 * @method SPA|null findOneBy(array $criteria, array $orderBy = null)
 * @method SPA[]    findAll()
 * @method SPA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SPARepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, SPA::class);
        $this->paginator = $paginator;
    }

    public function findAllPaginated($page)
    {
        $dbQuery = $this->createQueryBuilder('s')
            ->orderBy('s.name')
            ->getQuery();

        $paginatedSpas = $this->paginator->paginate($dbQuery, $page, 5);
        return $paginatedSpas;
    }

    // /**
    //  * @return SPA[] Returns an array of SPA objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SPA
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
