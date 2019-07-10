<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Service\MultitenantService;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CustomerRepository extends AbstractMultiTenantRepository
{
    private $paginator;

    public function __construct(RegistryInterface $registry, PaginatorInterface $paginator, MultitenantService $multitenantService)
    {
        parent::__construct($registry, Customer::class, $multitenantService);
        $this->paginator = $paginator;
    }

    public function findAllPaginated($page, $spaID)
    {
        $dbQuery = $this->createQueryBuilder('x')
            ->andWhere('x.spa = :spa_id')
            ->setParameter('spa_id', $spaID)
            ->orderBy('x.firstName')
            ->getQuery();

        $paginatedOperators = $this->paginator->paginate($dbQuery, $page, 5);
        return $paginatedOperators;
    }

    protected function enforceTenancy(int $spaID, QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->andWhere('x.spa = :spaId')
            ->setParameter('spaId', $spaID);
        return $queryBuilder;
    }
}
