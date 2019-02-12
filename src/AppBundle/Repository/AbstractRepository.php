<?php
/**
 * Created by PhpStorm.
 * User: Logidee
 * Date: 30/01/2019
 * Time: 16:07
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class AbstractRepository extends EntityRepository
{

    protected function paginate(QueryBuilder $qb, $limit = 20, $offset = 0)
    {
        if (0 == $limit || 0 == $offset) {
            throw new \LogicException('$limit & $offstet must be greater than 0.');
        }

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $currentPage = ceil($offset + 1) / $limit;
        $pager->setCurrentPage($currentPage);
        $pager->setMaxPerPage((int) $limit);

        return $pager;
    }

}