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
    public function findByUserID($userId)
    {
        $userContacts = $this->createQueryBuilder('uc')
            ->select()
            ->where('uc.user_id = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->getOneOrNullResult();
        
        return $userContacts;
    }
}