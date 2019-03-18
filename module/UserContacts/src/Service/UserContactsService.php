<?php

namespace UserContacts\Service;

use UserContacts\Creator\UserContactsCreator;
use UserContacts\Exceptions\ExistingUserContactsException;
use UserContacts\Repository\UserContactsRepository;
use Users\Service\UserService;

/**
 * Class UserContactsService
 *
 * @package UserContacts\Service
 */
class UserContactsService
{
    /**
     * @var UserContactsRepository
     */
    private $repository;

    /**
     * @var UserContactsCreator
     */
    private $creator;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(
        UserContactsRepository $repository,
        UserContactsCreator $creator,
        UserService $userService)
    {
        $this->repository = $repository;
        $this->creator = $creator;
        $this->userService = $userService;
    }

    /**
     * @param array $contactParameters
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function createUserContacts(array $contactParameters)
    {
       $user = $this->userService->getById($contactParameters['id']);

       $userContacts = $this->repository->findByUserID($contactParameters['id']);

       if ($userContacts)
       {
           throw new ExistingUserContactsException('User contacts already exist');
       }
       else{
           return $this->creator->insertUserContacts($user,$contactParameters);
       }

    }
}