<?php

namespace UserContactsAPI\V1\Rest\UserContacts;

use UserDetails\Service\UserContactsService;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class UserContactsResource extends AbstractResourceListener
{

    /**
     * @var UserContactsService
     */
    private $contactsService;

    public function __construct(UserContactsService $contactsService)
    {
        $this->contactsService = $contactsService;
    }

    /**
     * @param mixed $data
     *
     * @return mixed|UserContactsEntity|ApiProblem
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \UserDetails\Exceptions\EmptyAddressException
     * @throws \UserDetails\Exceptions\ExistingUserContactsException
     * @throws \UserDetails\Exceptions\InvalidPhoneNumberException
     */
    public function create($data)
    {
        $userContactParams['id'] = $this->getEvent()->getRouteMatch()->getParam('id');
        $userContactParams['address'] = $data->address;
        $userContactParams['phoneNumbers'] = $data->phoneNumber;
        $newUserContacts = $this->contactsService->createUserContacts($userContactParams);

        return UserContactsEntity::fromUserContactsEntity($newUserContacts);
    }

    /**
     * @param mixed $id
     * @param mixed $data
     *
     * @return mixed|UserContactsEntity|ApiProblem
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \UserDetails\Exceptions\EmptyAddressException
     */
    public function update($id, $data)
    {
        $editedParams['address'] = $data->address;

        $editedUserContacts = $this->contactsService->editUserContacts($id, $editedParams);

        return UserContactsEntity::fromUserContactsEntity($editedUserContacts);
    }

    /**
     * @param mixed $id
     * @param mixed $data
     *
     * @return mixed|UserContactsEntity|ApiProblem
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function patch($id, $data)
    {
        $editedParams = [
            'address' => '',
        ];

        if (property_exists($data, 'address')) {
            $editedParams['address'] = $data->address;
        }

        $patchedUserContacts = $this->contactsService->updateSeparateUserContactsParams($id, $editedParams);

        return UserContactsEntity::fromUserContactsEntity($patchedUserContacts);
    }

    /**
     * @param array $params
     *
     * @return mixed|UserContactsEntity|ApiProblem
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function fetchAll($params = [])
    {
        $userId = $this->getEvent()->getRouteMatch()->getParam('id');

        $userContacts = $this->contactsService->getUserContactsByUserId($userId);

        return UserContactsEntity::fromUserContactsEntity($userContacts);
    }
}
