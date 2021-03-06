<?php

namespace AppBundle\Repository;

/**
 * CommentaryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentaryRepository extends \Doctrine\ORM\EntityRepository
{
    public function getNbCom($article){
        $query = $this->createQueryBuilder('c')
            ->select('count(c)')
            ->where('c.article = :article')
            ->setParameter('article',$article)
            ->getQuery()
            ->getSingleScalarResult();

        return $query;
    }
}
