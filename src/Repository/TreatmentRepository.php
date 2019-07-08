<?php

namespace App\Repository;

use App\Entity\Treatment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Treatment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Treatment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Treatment[]    findAll()
 * @method Treatment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TreatmentRepository extends ServiceEntityRepository
{
    private $paginator;

    public function __construct(RegistryInterface $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Treatment::class);
        $this->paginator = $paginator;
    }

    public function findAllPaginated($page, $spaID)
    {
        $dbQuery = $this->createQueryBuilder('t')
            ->andWhere('t.spa = :spa_id')
            ->setParameter('spa_id', $spaID)
            ->orderBy('t.name')
            ->getQuery();

        $paginatedTreatments = $this->paginator->paginate($dbQuery, $page, 5);
        return $paginatedTreatments;
    }

    // /**
    //  * @return Treatment[] Returns an array of Treatment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Treatment
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
