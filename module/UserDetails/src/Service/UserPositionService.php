<?php

namespace UserDetails\Service;

use User\Entity\User;
use User\Service\UserService;
use UserDetails\Creator\UserPositionCreator;
use UserDetails\Entity\UserPosition;
use UserDetails\Exceptions\UserAlreadyHasPositionException;
use UserDetails\Validator\UserPositionValidator;
use UserDetails\Exceptions\InvalidUserPositionException;
use UserDetails\Exceptions\NotExistingUserContactsException;
use UserDetails\Repository\UserPositionRepository;

class UserPositionService
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var UserPositionValidator
     */
    private $positionValidator;

    /**
     * @var UserPositionCreator
     */
    private $userPositionCreator;

    /**
     * @var UserPositionRepository
     */
    private $positionRepository;

    public function __construct(
        UserPositionCreator $userPositionCreator,
        UserService $userService,
        UserPositionValidator $positionValidator,
        UserPositionRepository $positionRepository
    ) {
        $this->userService = $userService;
        $this->positionValidator = $positionValidator;
        $this->userPositionCreator = $userPositionCreator;
        $this->positionRepository = $positionRepository;
    }

    /**
     * @param array $userPositionParams
     *
     * @return UserPosition
     * @throws InvalidUserPositionException
     * @throws NotExistingUserContactsException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function addUserPosition(array $userPositionParams): UserPosition
    {
        $user = $this->userService->getById($userPositionParams['userId']);

        $this->validate($user, $userPositionParams['position']);

        $position = $this->positionRepository->findByPosition($userPositionParams['position']);

        if ($position) {
            if ($this->doesUserHavePosition($user, $position)) {
                throw new UserAlreadyHasPositionException('User already has position');
            }

            return $this->userPositionCreator->addUserToPosition($user, $position);
        }

        return $this->createNewPositionWithUser($user,$userPositionParams['position']);
    }

    /**
     * @param User         $user
     * @param UserPosition $position
     *
     * @return bool
     */
    public function doesUserHavePosition(User $user, UserPosition $position): bool
    {
        $users = $position->getUsers();

        return $users->contains($user);
    }

    /**
     * @param $user
     * @param $position
     *
     * @throws InvalidUserPositionException
     * @throws NotExistingUserContactsException
     */
    private function validate(User $user, string $position): void
    {
        if (!$user) {
            throw new NotExistingUserContactsException('User by that id does not exist');
        }

        $isPositionValid = $this->positionValidator->isPositionValid($position);

        if (!$isPositionValid) {
            throw new InvalidUserPositionException('Invalid user position');
        }
    }

    /**
     * @param User   $user
     * @param string $positionName
     *
     * @return UserPosition
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    private function createNewPositionWithUser(User $user,string $positionName): UserPosition
    {
        $position = $this->userPositionCreator->insertUserPosition($positionName);

        return $this->userPositionCreator->addUserToPosition($user, $position);
    }

}