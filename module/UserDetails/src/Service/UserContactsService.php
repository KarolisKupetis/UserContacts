<?php

namespace UserDetails\Service;


use UserDetails\Creator\UserContactsCreator;
use UserDetails\Editor\UserContactsEditor;
use UserDetails\Entity\UserContacts;
use UserDetails\Repository\UserContactsRepository;
use UserDetails\Validator\UserContactsValidator;
use User\Service\UserService;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use UserDetails\Exceptions\EmptyAddressException;
use UserDetails\Exceptions\ExistingUserContactsException;
use UserDetails\Exceptions\InvalidPhoneNumberException;
use UserDetails\Exceptions\NotExistingUserContactsException;

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
     * @return UserContacts
     * @throws EmptyAddressException
     * @throws ExistingUserContactsException
     * @throws InvalidPhoneNumberException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function createUserContacts(array $contactParameters): UserContacts
    {
        $contacts = $this->repository->findByUserID($contactParameters['id']);

        if ($contacts) {
            throw new ExistingUserContactsException('User contacts already exist');
        }

        $this->validate($contactParameters);

        $user = $this->userService->getById($contactParameters['id']);

        return $this->creator->insertUserContacts($user, $contactParameters);
    }

    /**
     * @param int   $id
     * @param array $editedParams
     *
     * @return UserContacts
     * @throws EmptyAddressException
     * @throws InvalidPhoneNumberException
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function editUserContacts(int $id, array $editedParams): UserContacts
    {
        $userContacts = $this->repository->getById($id);

        $this->validate($editedParams);

        return $this->editor->editUserContacts($userContacts, $editedParams);

    }

    /**
     * @param int   $id
     * @param array $editedParams
     *
     * @return UserContacts
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function updateSeparateUserContactsParams(int $id, array $editedParams): UserContacts
    {

        $userContacts = $this->repository->getById($id);

        if ($editedParams['phoneNumber'] === '') {
            $editedParams['phoneNumber'] = $userContacts->getPhoneNumber();
        }

        if ($editedParams['address'] === '') {
            $editedParams['address'] = $userContacts->getAddress();
        }

        return $this->editor->editUserContacts($userContacts, $editedParams);
    }

    /**
     * @param int $userId
     *
     * @return UserContacts|null
     * @throws NonUniqueResultException
     */
    public function getUserContactsByUserId(int $userId): ?UserContacts
    {
        return $this->repository->findByUserID($userId);
    }

    private function validate($contactParameters): void
    {
        if (!$this->validator->isValidPhoneNumber($contactParameters['phoneNumber'])) {
            throw new InvalidPhoneNumberException('Invalid phone number');
        }

        if (!$this->validator->isValidAddress($contactParameters['address'])) {
            throw new EmptyAddressException('No address given');
        }
    }
}