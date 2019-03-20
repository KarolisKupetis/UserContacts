<?php

namespace User\Repository;

use Doctrine\ORM\EntityRepository;
use User\Entity\User;

class UserRepository extends EntityRepository
{
    /**
     * @param $userId
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getById(int $userId) :User
    {
        return $this->createQueryBuilder('u')
            ->select()
            ->where('u.id = :name')
            ->setParameter('name', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}