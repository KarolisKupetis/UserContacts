<?php

namespace UserDetails\Repository;

use Doctrine\ORM\EntityRepository;
use User\Entity\User;
use UserDetails\Entity\UserPosition;

class UserPositionRepository extends EntityRepository
{
    /**
     * @param string $position
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByPosition(string $position): ?UserPosition
    {
        $userContacts = $this->createQueryBuilder('u')
            ->select()
            ->where('u.position= :position')
            ->setParameter('position', $position)
            ->getQuery()
            ->getOneOrNullResult();

        return $userContacts;
    }

    /**
     * @param User $user
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUser(User $user)
    {
        $userContacts = $this->createQueryBuilder('u')
            ->select()
            ->andWhere(':user MEMBER OF u.users')
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();

        return $userContacts;
    }
}