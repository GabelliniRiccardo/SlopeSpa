<?php

namespace App\Repository;

use App\Entity\Reservation;
use App\Service\MultitenantService;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ReservationRepository extends AbstractMultiTenantRepository
{
    private $paginator;
    protected $alias = 're';

    public function __construct(RegistryInterface $registry, PaginatorInterface $paginator, MultitenantService $multitenantService)
    {
        parent::__construct($registry, Reservation::class, $multitenantService);
        $this->paginator = $paginator;
    }

    public function findAllPastPaginated(int $page)
    {
        $dbQuery = $this->createQueryBuilder('re')
            ->orderBy('re.treatment')
            ->andWhere('re.end_time <= :now')
            ->setParameter('now', new \DateTime('now'))
            ->getQuery();

        $paginatedReservations = $this->paginator->paginate($dbQuery, $page, 5);
        return $paginatedReservations;
    }

    public function findAllFuturePaginated(int $page)
    {
        $dbQuery = $this->createQueryBuilder('re')
            ->orderBy('re.treatment')
            ->andWhere('re.end_time > :now')
            ->setParameter('now', new \DateTime('now'))
            ->getQuery();

        $paginatedReservations = $this->paginator->paginate($dbQuery, $page, 5);
        return $paginatedReservations;
    }

    public function getReservationsHistory()
    {
        $dbQuery = $this->createQueryBuilder('re')
            ->select('date(re.start_time) as startTime', 'COUNT(re) as numOfReservations')
            ->groupBy('startTime')
            ->orderBy('startTime')
            ->getQuery();

        return $dbQuery->getResult();
    }

    public function getReservations()
    {
        $dbQuery = $this->createQueryBuilder('re')
            ->select(
                're.id',
                'o.id as operatorId',
                'o.firstName as operatorFirstName',
                'o.lastName as operatorLastName',
                'c.firstName as customerFirstName',
                'c.lastName as customerLastName',
                't.name',
                't.money as price',
                're.start_time as start',
                're.end_time as end',
                'date(re.start_time) as year')
            ->join('re.treatment', 't')
            ->join('re.operator', 'o')
            ->join('re.customer', 'c')
            ->getQuery();

        return $dbQuery->getResult();
    }

    protected function enforceTenancy(int $spaID, QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->andWhere('re.spa = :spaId')
            ->setParameter('spaId', $spaID);
        return $queryBuilder;
    }
}
