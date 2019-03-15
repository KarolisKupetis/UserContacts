<?php


namespace UserContacts\Service;

use http\Client\Curl\User;
use UserContacts\Creator\UserContactsCreator;
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

    /**
     * UserContactsService constructor.
     *
     * @param UserContactsRepository $repository
     * @param UserContactsCreator    $creator
     */
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
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function insertUserContacts(array $contactParameters)
    {
       $user = $this->userService->getById($contactParameters['id']);

       $userContacts = $this->repository->findByUserID('id');

       if ($userContacts)
       {
           throw new \Exception('User contacts already exists');
       }

       return $this->creator->insertUserContacts($user,$contactParameters);
    }
}