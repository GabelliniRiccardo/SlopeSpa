<?php

namespace App\Repository;

use App\Entity\Reservation;
use App\Service\MultitenantService;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ReservationRepository extends AbstractMultiTenantRepository
{
    public function __construct(RegistryInterface $registry, MultitenantService $multitenantService)
    {
        parent::__construct($registry, Reservation::class, $multitenantService);
    }

    protected function enforceTenancy(int $spaID, QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->andWhere('x.spa = :spaId')
            ->setParameter('spaId', $spaID);
        return $queryBuilder;
    }
}
