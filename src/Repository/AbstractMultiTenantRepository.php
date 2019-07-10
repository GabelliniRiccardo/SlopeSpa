<?php


namespace App\Repository;


use App\Service\MultitenantService;
use Assert\Assertion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Intl\Exception\NotImplementedException;

abstract class AbstractMultiTenantRepository extends ServiceEntityRepository
{
    protected $multitenantService;

    public function __construct(ManagerRegistry $registry, $entityClass, MultitenantService $multitenantService)
    {
        parent::__construct($registry, $entityClass);
        $this->multitenantService = $multitenantService;
    }

    public function createQueryBuilder($alias, $indexBy = null): QueryBuilder
    {
        $queryBuilder = parent::createQueryBuilder($alias, $indexBy);
        if ($this->multitenantService->isMultitenant()) {
            Assertion::notNull($this->multitenantService->getSpaIdOfCurrentUser(), 'Tenancy cannot be enforced without a spa ID.');
            $queryBuilder = $this->enforceTenancy($this->multitenantService->getSpaIdOfCurrentUser(), $queryBuilder);
        }
        return $queryBuilder;
    }

    public function find($id, $lockMode = null, $lockVersion = null)
    {
        $queryBuilder = parent::createQueryBuilder('x');
        if ($this->multitenantService->isMultitenant()) {
            Assertion::notNull($this->multitenantService->getSpaIdOfCurrentUser(), 'Tenancy cannot be enforced without a spa ID.');
            $queryBuilder = $this->enforceTenancy($this->multitenantService->getSpaIdOfCurrentUser(), $queryBuilder);
        }
        $queryBuilder->andWhere('x.id = :id')->setParameter('id', $id);
        return $queryBuilder->getQuery()->getSingleResult();
    }

    protected abstract function enforceTenancy(int $spaID, QueryBuilder $queryBuilder): QueryBuilder;

    public function findAll()
    {
        throw new NotImplementedException('findAll() method on AbstractMultiTenantRepository cannot be callable');
    }

    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        throw new NotImplementedException('findby() method on AbstractMultiTenantRepository cannot be callable');
    }

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        throw new NotImplementedException('findOneBy() method on AbstractMultiTenantRepository cannot be callable');
    }
}
