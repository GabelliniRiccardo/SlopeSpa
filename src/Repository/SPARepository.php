<?php

namespace App\Repository;

use App\Entity\SPA;
use App\Service\MultitenantService;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Knp\Component\Pager\PaginatorInterface;

class SPARepository extends AbstractMultiTenantRepository
{
    protected $alias = 's';

    public function __construct(RegistryInterface $registry, PaginatorInterface $paginator, MultitenantService $multitenantService)
    {
        parent::__construct($registry, SPA::class, $multitenantService);
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

    protected function enforceTenancy(int $spaID, QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->andWhere('s.id = :spaId')
            ->setParameter('spaId', $spaID);
        return $queryBuilder;
    }
}
