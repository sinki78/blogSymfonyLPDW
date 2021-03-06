<?php

namespace AppBundle\Repository;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{
    /** use */
    public function getBySearchTN($tags,$name){
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.tags', 't')
            ->where('t.id IN (:tags)')
            ->setParameter(':tags', $tags)
            ->orWhere('a.name LIKE :search')
            ->setParameter(':search', '%'.$name.'%')
            ->getQuery()
            ->getResult();

        return $query;
    }

    /** use */
    public function getBySearchT($tags){
        $query = $this->createQueryBuilder('a')
            ->leftJoin('a.tags', 't')
            ->where('t.id IN (:tags)')
            ->setParameter(':tags', $tags)
            ->getQuery()
            ->getResult();
        return $query;
    }


    /** use */
    public function getLastFive(){
        $query = $this->createQueryBuilder('a')
            ->orderBy('a.releaseDate','DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
        return $query;
    }


}
