<?php

namespace UserContacts\Service;

use UserContacts\Creator\UserContactsCreator;
use UserContacts\Exceptions\EmptyAddressException;
use UserContacts\Exceptions\ExistingUserContactsException;
use UserContacts\Exceptions\InvalidPhoneNumberException;
use UserContacts\Repository\UserContactsRepository;
use UserContacts\Validator\UserContactsValidator;
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
     * @var UserContactsValidator
     */
    private $validator;

    public function __construct(
        UserContactsRepository $repository,
        UserContactsCreator $creator,
        UserService $userService,
        UserContactsValidator $validator
    ) {
        $this->repository = $repository;
        $this->creator = $creator;
        $this->userService = $userService;
        $this->validator = $validator;
    }

    /**
     * @param array $contactParameters
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function createUserContacts(array $contactParameters)
    {
        if (!$this->validator->isValidPhoneNumber($contactParameters['phoneNumber'])) {
            throw new InvalidPhoneNumberException('Invalid phone number');
        }

        if (!$this->validator->isValidAddress($contactParameters['address'])) {
            throw new EmptyAddressException('No address given');
        }

        $userContacts = $this->repository->findByUserID($contactParameters['id']);

        if ($userContacts) {
            throw new ExistingUserContactsException('User contacts already exist');
        } else {

            $user = $this->userService->getById($contactParameters['id']);

            return $this->creator->insertUserContacts($user, $contactParameters);
        }

    }
}