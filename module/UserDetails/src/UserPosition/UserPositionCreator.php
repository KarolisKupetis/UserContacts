<?php

namespace UserDetails\Creator;

use Doctrine\ORM\EntityManager;
use User\Entity\User;
use UserDetails\Entity\UserPosition;

class UserPositionCreator
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {

        $this->entityManager = $entityManager;
    }

    /**
     * @param string $positionName
     *
     * @return UserPosition
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insertUserPosition(string $positionName): UserPosition
    {
        $newUserPosition = $this->createUserPositionEntity($positionName);
        $this->entityManager->persist($newUserPosition);
        $this->entityManager->flush();

        return $newUserPosition;
    }

    /**
     * @param $positionName
     *
     * @return UserPosition
     */
    private function createUserPositionEntity($positionName): UserPosition
    {
        $newUserPosition = new UserPosition();
        $newUserPosition->setPosition($positionName);

        return $newUserPosition;
    }

    /**
     * @param User         $user
     * @param UserPosition $position
     *
     * @return UserPosition
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addUserToPosition(User $user, UserPosition $position): UserPosition
    {
        $position->addUser($user);
        $this->entityManager->persist($position);
        $this->entityManager->flush();

        return $position;
    }


}