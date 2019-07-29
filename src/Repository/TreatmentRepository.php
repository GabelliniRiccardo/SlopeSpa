<?php

namespace App\Repository;

use App\Entity\Treatment;
use App\Service\MultitenantService;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class TreatmentRepository extends AbstractMultiTenantRepository
{
    private $paginator;
    protected $alias = 't';

    public function __construct(RegistryInterface $registry, PaginatorInterface $paginator, MultitenantService $multitenantService)
    {
        parent::__construct($registry, Treatment::class, $multitenantService);
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

    public function findAvailableTreatmentsUsingOperator(int $operatorId, \DateTimeImmutable $startTime, \DateTimeImmutable $endTime, ?int $reservationIdToIgnore)
    {
        $subqueryBuilder = $this->createQueryBuilder('xx');
        $subQuery = $subqueryBuilder
            ->join('xx.reservations', 'r')
            ->andWhere('r.operator = :operatorId')
            ->setParameter('operatorId', $operatorId)
            ->andWhere('(r.start_time BETWEEN :startTime AND :endTime) OR (r.end_time BETWEEN :startTime AND :endTime)')
            ->setParameter('startTime', $startTime)
            ->setParameter('endTime', $endTime);

        if ($reservationIdToIgnore) {
            $subQuery = $subQuery->andWhere('r.id != :reservationIdToIgnore')
                ->setParameter('reservationIdToIgnore', $reservationIdToIgnore);
        }
        $subQuery = $subQuery->getQuery();

        $queryBuilder = $this->createQueryBuilder('t');
        $query = $queryBuilder
            ->join('t.operators', 'o')
            ->andWhere('o.id = :operatorId')
            ->andwhere($queryBuilder->expr()->notIn('t', $subQuery->getDQL()))
            ->setParameter('operatorId', $operatorId)
            ->setParameter('startTime', $startTime)
            ->setParameter('endTime', $endTime);

        if ($reservationIdToIgnore) {
            $query = $query->setParameter('reservationIdToIgnore', $reservationIdToIgnore);
        }
        $query = $query->getQuery();

        return $query->getResult();
    }

    public function getNumberOfReservationPerTreatment()
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->select('t.id', 't.name', 'COUNT(r) as numOfReservations')
            ->leftJoin('t.reservations', 'r')
            ->groupBy('t.id')
            ->addgroupBy('t.name')
            ->orderBy('t.name')
            ->getQuery();
        return $queryBuilder->getResult();
    }

    protected function enforceTenancy(int $spaID, QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->andWhere('t.spa = :spaId')
            ->setParameter('spaId', $spaID);
        return $queryBuilder;
    }
}
