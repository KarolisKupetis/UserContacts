<?php

namespace UserContacts\Service;

use UserContacts\Creator\UserContactsCreator;
use UserContacts\Editor\UserContactsEditor;
use UserContacts\Entity\UserContacts;
use UserContacts\Exceptions\EmptyAddressException;
use UserContacts\Exceptions\ExistingUserContactsException;
use UserContacts\Exceptions\InvalidPhoneNumberException;
use UserContacts\Repository\UserContactsRepository;
use UserContacts\Validator\UserContactsValidator;
use UserContactsAPI\V1\Rest\UserContacts\UserContactsEntity;
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
    /**
     * @var UserContactsEditor
     */
    private $editor;

    public function __construct(
        UserContactsRepository $repository,
        UserContactsCreator $creator,
        UserService $userService,
        UserContactsValidator $validator,
        UserContactsEditor $editor
    ) {
        $this->repository = $repository;
        $this->creator = $creator;
        $this->userService = $userService;
        $this->validator = $validator;
        $this->editor = $editor;
    }

    /**
     * @param array $contactParameters
     *
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public
    function createUserContacts(
        array $contactParameters
    ) {
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

    /**
     * @param int   $id
     * @param array $editedParams
     *
     * @return UserContactsEntity
     * @throws EmptyAddressException
     * @throws InvalidPhoneNumberException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \UserContacts\Exceptions\NotExistingUserContactsException
     */
    public function editUserContacts(int $id, array $editedParams): UserContacts
    {
        $userContacts = $this->repository->getById($id);

        $isPhoneNumberValid = $this->validator->isValidPhoneNumber($editedParams['phoneNumber']);
        $isAddressValid = $this->validator->isValidAddress($editedParams['address']);

        if (!$isPhoneNumberValid) {

            throw new InvalidPhoneNumberException('Invalid phone number');
        }

        if (!$isAddressValid) {
            throw new EmptyAddressException('Invalid address');
        }

        return $this->editor->editUserContacts($userContacts, $editedParams);

    }
}