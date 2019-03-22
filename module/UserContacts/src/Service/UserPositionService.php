<?php

namespace UserContacts\Service;

use User\Service\UserService;
use UserContacts\Creator\UserPositionCreator;
use UserContacts\Entity\UserPosition;
use UserContacts\Exceptions\InvalidUserPositionException;
use UserContacts\Exceptions\NotExistingUserContactsException;
use UserContacts\Validator\UserPositionValidator;

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

    public function __construct(
        UserService $userService,
        UserPositionValidator $positionValidator,
        UserPositionCreator $userPositionCreator
    ) {

        $this->userService = $userService;
        $this->positionValidator = $positionValidator;
        $this->userPositionCreator = $userPositionCreator;
    }

    /**
     * @param array $userPositionParams
     *
     * @return int
     * @throws InvalidUserPositionException
     * @throws NotExistingUserContactsException
     * @throws \Exception
     */
    public function addUserPosition(array $userPositionParams): UserPosition
    {
        $user = $this->userService->getById($userPositionParams['userId']);

        if (!$user) {
            throw new NotExistingUserContactsException('User by that id does not exist');
        }

        $isPositionValid = $this->positionValidator->isPositionValid($userPositionParams['position']);

        if (!$isPositionValid) {
            throw new InvalidUserPositionException('Invalid user position');
        }

        return $this->userPositionCreator->insertUserPosition($user,$userPositionParams);
    }
}