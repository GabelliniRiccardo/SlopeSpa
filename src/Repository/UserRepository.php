<?php

namespace App\Repository;

use App\Entity\User;
use App\Service\MultitenantService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

class UserRepository extends AbstractMultiTenantRepository
{
    private $paginator;

    public function __construct(RegistryInterface $registry, PaginatorInterface $paginator, MultitenantService $multitenantService)
    {
        parent::__construct($registry, User::class, $multitenantService);
        $this->paginator = $paginator;
    }

    public function findAllPaginated($page, $spaID)
    {
        $dbQuery = $this->createQueryBuilder('x')
            ->andWhere('x.spa = :spa_id')
            ->setParameter('spa_id', $spaID)
            ->getQuery();

        $paginatedUsers = $this->paginator->paginate($dbQuery, $page, 5);
        return $paginatedUsers;
    }

    public function findUserByEmail(string $email)
    {
        return $this->createQueryBuilder('x')
            ->andWhere('x.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    protected function enforceTenancy(int $spaID, QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->andWhere('x.spa = :spaId')
            ->setParameter('spaId', $spaID);
        return $queryBuilder;
    }
}
