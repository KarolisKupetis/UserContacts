<?php

namespace UserDetails\Service;

use UserDetails\Creator\UserContactsCreator;
use UserDetails\Editor\UserContactsEditor;
use UserDetails\Entity\UserContacts;
use UserDetails\Repository\UserContactsRepository;
use UserDetails\Validator\UserContactsValidator;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\NonUniqueResultException;
use UserDetails\Exceptions\EmptyAddressException;
use UserDetails\Exceptions\ExistingUserContactsException;

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
        UserContactsValidator $validator,
        UserContactsEditor $editor
    ) {
        $this->repository = $repository;
        $this->creator = $creator;
        $this->validator = $validator;
        $this->editor = $editor;
    }

    /**
     * @param array $contactParameters
     *
     * @return UserContacts
     * @throws EmptyAddressException
     * @throws ExistingUserContactsException
     * @throws NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createUserContacts(array $contactParameters): UserContacts
    {
        $contacts = $this->repository->findByUserId($contactParameters['id']);

        if ($contacts) {
            throw new ExistingUserContactsException('User contacts already exist');
        }

        if (!$this->validator->isValidAddress($contactParameters['address'])) {
            throw new EmptyAddressException('No address given');
        }

        $userContacts = $this->creator->insertUserContacts($contactParameters);

        return $this->creator->addPhoneNumbersToUserContacts($contactParameters['phoneNumbers'], $userContacts);
    }

    /**
     * @param int   $id
     * @param array $editedParams
     *
     * @return UserContacts
     * @throws EmptyAddressException
     * @throws NoResultException
     * @throws NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \UserDetails\Exceptions\InvalidPhoneNumberException
     */
    public function editUserContacts(int $id, array $editedParams): UserContacts
    {
        $userContacts = $this->repository->getById($id);

        if (!$this->validator->isValidAddress($editedParams['address'])) {
            throw new EmptyAddressException('No address given');
        }

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
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \UserDetails\Exceptions\InvalidPhoneNumberException
     */
    public function updateSeparateUserContactsParams(int $id, array $editedParams): UserContacts
    {
        $userContacts = $this->repository->getById($id);

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
        return $this->repository->findByUserId($userId);
    }
}