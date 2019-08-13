<?php

namespace App\Repository;

use App\Entity\Operator;
use App\Service\MultitenantService;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class OperatorRepository extends AbstractMultiTenantRepository
{
    private $paginator;
    protected $alias = 'o';

    public function __construct(RegistryInterface $registry, PaginatorInterface $paginator, MultitenantService $multitenantService)
    {
        parent::__construct($registry, Operator::class, $multitenantService);
        $this->paginator = $paginator;
    }

    public function findAllPaginated($page, $spaID)
    {
        $dbQuery = $this->createQueryBuilder('o')
            ->andWhere('o.spa = :spa_id')
            ->setParameter('spa_id', $spaID)
            ->orderBy('o.firstName')
            ->getQuery();

        $paginatedOperators = $this->paginator->paginate($dbQuery, $page, 5);
        return $paginatedOperators;
    }

    public function findAvailableOperatorsUsingTreatment(int $treatmentId, \DateTimeImmutable $startTime, \DateTimeImmutable $endTime, ?int $reservationIdToIgnore)
    {
        $subqueryBuilder = $this->createQueryBuilder('xx');

        $subQuery = $subqueryBuilder
            ->join('xx.treatments', 't')
            ->andWhere('t.id = :treatmentId')
            ->setParameter('treatmentId', $treatmentId)
            ->join('xx.reservations', 'r')
            ->andWhere(
                '(r.start_time > :startTime AND r.start_time < :endTime)
                 OR (r.end_time > :startTime AND r.end_time < :endTime)
                 OR (r.start_time <= :startTime AND r.end_time >= :endTime)'
            )
            ->setParameter('startTime', $startTime)
            ->setParameter('endTime', $endTime);

        if ($reservationIdToIgnore) {
            $subQuery = $subQuery->andWhere('r.id != :reservationIdToIgnore')
                ->setParameter('reservationIdToIgnore', $reservationIdToIgnore);
        }
        $subQuery = $subQuery->getQuery();

        $queryBuilder = $this->createQueryBuilder('o');
        $query = $queryBuilder
            ->join('o.treatments', 'tr')
            ->andWhere('tr.id = :treatmentId')
            ->andwhere($queryBuilder->expr()->notIn('o', $subQuery->getDQL()))
            ->setParameter('treatmentId', $treatmentId)
            ->setParameter('startTime', $startTime)
            ->setParameter('endTime', $endTime);

        if ($reservationIdToIgnore) {
            $query = $query->setParameter('reservationIdToIgnore', $reservationIdToIgnore);
        }
        $query = $query->getQuery();

        return $query->getResult();
    }

    public function getNumberOfReservationPerOperator()
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->select('o.id', 'o.firstName', 'o.lastName', 'COUNT(r) as numOfReservations')
            ->leftjoin('o.reservations', 'r')
            ->groupBy('o.id')
            ->addgroupBy('o.firstName')
            ->addGroupBy('o.lastName')
            ->orderBy('o.firstName')
            ->getQuery();
        return $queryBuilder->getResult();
    }

    public function getIdFirstNameAndLastNameOfAllOperators()
    {
        $queryBuilder = $this->createQueryBuilder('o')
            ->select('o.id', 'o.firstName', 'o.lastName')
            ->getQuery();
        return $queryBuilder->getResult();
    }

    protected function enforceTenancy(int $spaID, QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->andWhere('o.spa = :spaId')
            ->setParameter('spaId', $spaID);
        return $queryBuilder;
    }
}
