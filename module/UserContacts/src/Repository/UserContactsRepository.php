<?php

namespace UserContacts\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use UserContacts\Entity\UserContacts;
use UserContacts\Exceptions\NotExistingUserContactsException;

class UserContactsRepository extends EntityRepository
{
    /**
     * @param $userId
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUserID(int $userId): ?UserContacts
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
}