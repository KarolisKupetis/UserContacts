<?php


namespace UserContacts\Creator;


use Doctrine\ORM\EntityManager;
use User\Entity\User;
use UserContacts\Entity\UserPosition;

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
     * @param User  $user
     * @param array $userPositionParams
     *
     * @return int
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function insertUserPosition(User $user, array $userPositionParams): UserPosition
    {
        $newUserPosition = $this->createUserPositionEntity($user, $userPositionParams);
        $this->entityManager->persist($newUserPosition);
        $this->entityManager->flush();

        return $newUserPosition;
    }

    /**
     * @param User  $user
     * @param array $userPositionParams
     *
     * @return UserPosition
     */
    private function createUserPositionEntity(User $user, array $userPositionParams): UserPosition
    {
        $newUserPosition = new UserPosition();
        $newUserPosition->setUser($user);
        $newUserPosition->setPosition($userPositionParams['position']);

        return $newUserPosition;
    }
}