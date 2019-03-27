<?php

namespace UserDetails\Service;

use User\Entity\User;
use User\Service\UserService;
use UserDetails\Creator\UserPositionCreator;
use UserDetails\Entity\UserPosition;
use UserDetails\Exceptions\NotExistingUserException;
use UserDetails\Validator\UserPositionValidator;
use UserDetails\Exceptions\InvalidUserPositionException;
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
     * @throws NotExistingUserException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function changeUserPosition(array $userPositionParams): UserPosition
    {
        $user = $this->userService->getById($userPositionParams['userId']);
        $this->validateUserAndPositionName($user, $userPositionParams['position']);
        $position = $this->positionRepository->findByPosition($userPositionParams['position']);

        if (!$position) {
            $position = $this->userPositionCreator->createUserPosition($userPositionParams['position']);
        }

        $userHasPosition = $this->positionRepository->findByUser($user);

        if ($userHasPosition) {
            $this->userPositionCreator->removePositionFromUser($user, $userHasPosition);
        }

        return $this->userPositionCreator->addPositionToUser($user, $position);
    }

    /**
     * @param User   $user
     * @param string $position
     *
     * @throws InvalidUserPositionException
     * @throws NotExistingUserException
     */
    private function validateUserAndPositionName(User $user, string $position): void
    {
        if (!$user) {
            throw new NotExistingUserException('User by that id does not exist');
        }

        $isPositionValid = $this->positionValidator->isPositionValid($position);

        if (!$isPositionValid) {
            throw new InvalidUserPositionException('Invalid user position');
        }
    }
}