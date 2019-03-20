<?php

namespace User\Service;

use User\Entity\User;
use User\Repository\UserRepository;

/**
 * Class UserService
 *
 * @package Users\Service
 */
class UserService
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $userId
     *
     * @return mixed
     * @throws \Exception
     */
    public function getById(int $userId): User
    {
        return $this->userRepository->getById($userId);
    }
}