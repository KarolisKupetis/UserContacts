<?php


namespace UserContacts\Repository;


use Doctrine\ORM\EntityRepository;
use UserContacts\Entity\UserPosition;

class UserPositionRepository extends EntityRepository
{

    /**
     * @param $userContactsId
     *
     * @return UserPosition
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByUserContactsId(int $userContactsId):UserPosition
    {
        $userContacts = $this->createQueryBuilder('u')
            ->select()
            ->where('u.userContacts= :id')
            ->setParameter('id', $userContactsId)
            ->getQuery()
            ->getOneOrNullResult();

        return $userContacts;
    }
}