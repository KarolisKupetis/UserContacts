<?php

namespace UserDetails\Editor;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use UserDetails\Entity\UserContacts;
use UserDetails\Service\UserPhoneNumberService;

class UserContactsEditor
{
    /**
     * @var EntityManager
     */
    private $entityManager;
    /**
     * @var UserPhoneNumberService
     */
    private $numberService;

    public function __construct(EntityManager $entityManager,UserPhoneNumberService $numberService)
    {
        $this->entityManager = $entityManager;
        $this->numberService = $numberService;
    }

    /**
     * @param UserContacts $userContacts
     * @param array        $editedParams
     *
     * @return UserContacts
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \UserDetails\Exceptions\InvalidPhoneNumberException
     */
    public function editUserContacts(UserContacts $userContacts, array $editedParams): UserContacts
    {
        $userContacts->setAddress($editedParams['address']);
        $phoneNumbers = new ArrayCollection();

        foreach ($editedParams['phoneNumber'] as $phoneNumber)
        {
            $newPhoneNumber = $this->numberService->createUserPhoneNumberEntity($phoneNumber);

            $newPhoneNumber->setUserContacts($userContacts);

            $phoneNumbers [] = $newPhoneNumber;
        }

        $oldPhoneNumbers = $userContacts->getPhoneNumbers();

        foreach ($oldPhoneNumbers as $oldPhoneNumber)
        {
            $this->entityManager->remove($oldPhoneNumber);
        }

        $userContacts->setPhoneNumbers($phoneNumbers);
        $this->entityManager->persist($userContacts);
        $this->entityManager->flush();

        return $userContacts;
    }
}