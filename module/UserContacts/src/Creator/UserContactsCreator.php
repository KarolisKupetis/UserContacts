<?php


namespace UserContacts\Creator;


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use UserContacts\Entity\UserContacts;
use UserContactsAPI\V1\Rest\Usercontacts\UsercontactsEntity;
use Users\Entity\User;

/**
 * Class UserContactsCreator
 *
 * @package UserContacts\Creator
 */
class UserContactsCreator
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * UserContactsCreator constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param User  $user
     * @param array $contactParameters
     *
     * @return mixed
     */
    public function insertUserContacts(User $user, array $contactParameters)
    {
      $newUserContacts = $this->createUserContactsEntity($user,$contactParameters);

        try {

            $this->entityManager->persist($newUserContacts);

        } catch (ORMException $e) {
            throwException($e);
        }

        try {

            $this->entityManager->flush();

        } catch (OptimisticLockException $e) {
        } catch (ORMException $e) {
            throwException($e);
        }

        return $newUserContacts->getId();
    }

    /**
     * @param User  $user
     * @param array $contactParameters
     *
     * @return UserContacts
     */
    private function createUserContactsEntity(User $user,array $contactParameters):UserContacts
    {
        $userContacts = new UserContacts();
        $userContacts->setAddress($contactParameters['address']);
        $userContacts->setPhoneNumber($contactParameters['phoneNumber']);
        $userContacts->setUser($user);

        return $userContacts;
    }
}