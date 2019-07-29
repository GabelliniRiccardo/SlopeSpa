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
    protected $alias = 'u';

    public function __construct(RegistryInterface $registry, PaginatorInterface $paginator, MultitenantService $multitenantService)
    {
        parent::__construct($registry, User::class, $multitenantService);
        $this->paginator = $paginator;
    }

    public function findAllPaginated($page, $spaID)
    {
        $dbQuery = $this->createQueryBuilder('u')
            ->andWhere('u.spa = :spa_id')
            ->setParameter('spa_id', $spaID)
            ->getQuery();

        $paginatedUsers = $this->paginator->paginate($dbQuery, $page, 5);
        return $paginatedUsers;
    }

    public function findUserByEmail(string $email)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    protected function enforceTenancy(int $spaID, QueryBuilder $queryBuilder): QueryBuilder
    {
        $queryBuilder
            ->andWhere('u.spa = :spaId')
            ->setParameter('spaId', $spaID);
        return $queryBuilder;
    }
}
