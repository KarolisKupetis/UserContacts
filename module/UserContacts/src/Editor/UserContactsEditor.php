<?php


namespace UserContacts\Editor;

use Doctrine\ORM\EntityManager;
use UserContacts\Entity\UserContacts;

class UserContactsEditor
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param UserContacts $userContacts
     * @param array        $editedParams
     *
     * @return UserContacts
     * @throws \Doctrine\ORM\ORMException
     */
    public function editUserContacts(UserContacts $userContacts, array $editedParams): UserContacts
    {
        $userContacts->setPhoneNumber($editedParams['phoneNumber']);
        $userContacts->setAddress($editedParams['address']);
        $this->entityManager->persist($userContacts);
        $this->entityManager->flush();

        return $userContacts;
    }
}