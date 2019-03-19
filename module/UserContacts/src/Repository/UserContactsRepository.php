<?php

namespace UserContacts\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use UserContacts\Exceptions\NotExistingUserContacts;

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

    /**
     * @param int $id
     *
     * @return mixed
     * @throws NonUniqueResultException
     * @throws NotExistingUserContacts
     */
    public function getById(int $id)
    {
        try {
            return $this->createQueryBuilder('a')
                ->select()
                ->where('a.id = :id')
                ->setParameter('id', $id)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {

            throw new NotExistingUserContacts('UserContacts by that Id does not exist');
        }
    }
}