<?php

namespace UserContacts\Service;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use UserContacts\Creator\UserContactsCreator;
use UserContacts\Editor\UserContactsEditor;
use UserContacts\Entity\UserContacts;
use UserContacts\Exceptions\EmptyAddressException;
use UserContacts\Exceptions\ExistingUserContactsException;
use UserContacts\Exceptions\InvalidPhoneNumberException;
use UserContacts\Exceptions\NotExistingUserContactsException;
use UserContacts\Repository\UserContactsRepository;
use UserContacts\Validator\UserContactsValidator;
use User\Service\UserService;

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
    public function createUserContacts(array $contactParameters): UserContacts
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

    /**
     * @param int   $id
     * @param array $editedParams
     *
     * @return UserContacts
     * @throws EmptyAddressException
     * @throws InvalidPhoneNumberException
     * @throws NonUniqueResultException
     * @throws NotExistingUserContactsException
     * @throws \Doctrine\ORM\ORMException
     */
    public function editUserContacts(int $id, array $editedParams): UserContacts
    {
        try {
            $userContacts = $this->repository->getById($id);
        } catch (NoResultException $e) {
            throw new NotExistingUserContactsException('UserContacts by that id does not exist');
        }

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

    /**
     * @param int   $id
     * @param array $editedParams
     *
     * @return UserContacts
     * @throws InvalidPhoneNumberException
     * @throws NonUniqueResultException
     * @throws NotExistingUserContactsException
     * @throws \Doctrine\ORM\ORMException
     */
    public function updateSeparateUserContactsParams(int $id, array $editedParams): UserContacts
    {
        try {
            $userContacts = $this->repository->getById($id);
        } catch (NoResultException $e) {
            throw new NotExistingUserContactsException('User contacts by that id does not exist');
        }

        if ($editedParams['phoneNumber'] === '') {
            $editedParams['phoneNumber'] = $userContacts->getPhoneNumber();
        }

        if ($editedParams['address'] === '') {
            $editedParams['address'] = $userContacts->getAddress();
        }

        $isPhoneNumberValid = $this->validator->isValidPhoneNumber($editedParams['phoneNumber']);

        if (!$isPhoneNumberValid) {

            throw new InvalidPhoneNumberException('Invalid phone number');
        }

        return $this->editor->editUserContacts($userContacts, $editedParams);
    }

    /**
     * @param $id
     *
     * @return UserContacts
     * @throws NonUniqueResultException
     * @throws NotExistingUserContactsException
     */
    public function getUserContactsById($id): UserContacts
    {
        try {

            return $this->repository->getById($id);

        } catch (NoResultException $e) {

            throw new NotExistingUserContactsException('User contact by that id does not exist');
        }
    }

    /**
     * @param int $userId
     *
     * @return UserContacts|null
     * @throws NonUniqueResultException
     */
    public function getUserContactsByUserId(int $userId):?UserContacts
    {
       return $this->repository->findByUserID($userId);
    }
}