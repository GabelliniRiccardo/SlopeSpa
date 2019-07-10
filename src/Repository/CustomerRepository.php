<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Service\MultitenantService;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

class CustomerRepository extends AbstractMultiTenantRepository
{
    public function __construct(RegistryInterface $registry, MultitenantService $multitenantService)
    {
        parent::__construct($registry, Customer::class, $multitenantService);
    }

    protected function enforceTenancy(int $spaID, QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->andWhere('x.spa = :spaId')
            ->setParameter('spaId', $spaID);
        return $queryBuilder;
    }
}
