<?php

namespace UserDetails\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use UserDetails\Entity\UserContacts;

class UserContactsRepository extends EntityRepository
{
    /**
     * @param $userId
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUserId(int $userId): ?UserContacts
    {
        $userContacts = $this->createQueryBuilder('u')
            ->select()
            ->where('u.user = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->getOneOrNullResult();

        return $userContacts;
    }

    /**
     * @param int $id
     *
     * @return UserContacts
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getById(int $id): UserContacts
    {
        return $this->createQueryBuilder('u')
            ->select()
            ->where('u.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @param int $userId
     *
     * @return UserContacts|null
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function getByUserId(int $userId): ?UserContacts
    {
        $userContacts = $this->createQueryBuilder('u')
            ->select()
            ->where('u.user = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->getSingleResult();

        return $userContacts;
    }
}