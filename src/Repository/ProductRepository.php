<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr;

/**
 * Class ProductRepository
 * @package App\Repository
 */
class ProductRepository extends EntityRepository implements RepositoryInterface
{
    /**
     * @return mixed
     */
    public function findAllOrderedByName()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p FROM App:Product p ORDER BY p.name ASC'
            )
            ->getResult();
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return parent::findAll();
    }

    /**
     * @param array $ids
     *
     * @return float|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getTotalPriceByIds(array $ids): ?float
    {
        $qb = $this->getEntityManager()
            ->createQueryBuilder();
        return $qb
            ->select(['COALESCE(SUM(price), 0)'])
            ->where($qb->expr()->in('p.id', $ids))
            ->from((new Expr())->from('App:Product'), 'p')
            ->getQuery()
            ->getSingleScalarResult();
    }
}
