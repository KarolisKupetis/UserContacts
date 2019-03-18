<?php

namespace UserContacts\Repository;

use Doctrine\ORM\EntityRepository;

class UserContactsRepository extends EntityRepository
{
    /**
     * @param $userId
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUserID(int $userId)
    {
        $userContacts = $this->createQueryBuilder('a')
            ->select()
            ->where('a.user = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->getOneOrNullResult();
        
        return $userContacts;
    }
}