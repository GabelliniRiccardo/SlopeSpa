<?php

namespace App\Repository;

use App\Entity\SPA;
use App\Service\MultitenantService;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Knp\Component\Pager\PaginatorInterface;

class SPARepository extends AbstractMultiTenantRepository
{
    public function __construct(RegistryInterface $registry, PaginatorInterface $paginator, MultitenantService $multitenantService)
    {
        parent::__construct($registry, SPA::class, $multitenantService);
        $this->paginator = $paginator;
    }

    public function findAllPaginated($page)
    {
        $dbQuery = $this->createQueryBuilder('x')
            ->orderBy('x.name')
            ->getQuery();

        $paginatedSpas = $this->paginator->paginate($dbQuery, $page, 5);
        return $paginatedSpas;
    }

    protected function enforceTenancy(int $spaID, QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->andWhere('x.id = :spaId')
            ->setParameter('spaId', $spaID);
        return $queryBuilder;
    }
}
