<?php

namespace Users\Service;

use Users\Repository\UsersRepository;

/**
 * Class UserService
 *
 * @package Users\Service
 */
class UserService
{
    /**
     * @var UsersRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     *
     * @param UsersRepository $userRepository
     */
    public function __construct(UsersRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $userId
     *
     * @return mixed
     * @throws \Exception
     */
    public function getById(int $userId)
    {
       return $this->userRepository->getById($userId);
    }
}