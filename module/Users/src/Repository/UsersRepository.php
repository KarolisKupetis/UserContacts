<?php

namespace Users\Repository;

use Doctrine\ORM\EntityRepository;

class UsersRepository extends EntityRepository
{
    /**
     * @param $userId
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getById($userId)
    {
        return $this->createQueryBuilder('a')
            ->select()
            ->where('a.id = :name')
            ->setParameter('name',$userId)
            ->getQuery()
            ->getOneOrNullResult();
    }
}