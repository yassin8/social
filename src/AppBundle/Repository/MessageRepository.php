<?php

namespace AppBundle\Repository;

/**
 * MessageRepository
 */
class MessageRepository extends \Doctrine\ORM\EntityRepository
{
    public function findById($search)
    {
        return $this->createQueryBuilder('p')
            ->setParameter('search', $search )
            ->where('p.student = :search or p.teacher = :search')
            ->getQuery()
            ->getResult();
    }
}
