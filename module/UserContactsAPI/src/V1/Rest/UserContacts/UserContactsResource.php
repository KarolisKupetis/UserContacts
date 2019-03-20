<?php

namespace UserContactsAPI\V1\Rest\UserContacts;

use UserContacts\Service\UserContactsService;
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
     * @return array|mixed|ApiProblem
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function create($data)
    {
        $userContactParams['id'] = $this->getEvent()->getRouteMatch()->getParam('userid');
        $userContactParams['address'] = $data->address;
        $userContactParams['phoneNumber'] = $data->phone_number;
        $userContactsId = $this->contactsService->createUserContacts($userContactParams);

        return ['id' => $userContactsId];
    }

    /**
     * @param mixed $id
     * @param mixed $data
     *
     * @return mixed|void|ApiProblem
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \UserContacts\Exceptions\EmptyAddressException
     * @throws \UserContacts\Exceptions\InvalidPhoneNumberException
     * @throws \UserContacts\Exceptions\NotExistingUserContactsException
     */
    public function update($id, $data)
    {
        $editedParams['address'] = $data->address;
        $editedParams['phoneNumber'] = $data->phone_number;

        $editedUserContacts = $this->contactsService->editUserContacts($id, $editedParams);

        return UserContactsEntity::fromUserContactsEntity($editedUserContacts);
    }

    /**
     * @param mixed $id
     * @param mixed $data
     *
     * @return mixed|void|ApiProblem
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \UserContacts\Exceptions\InvalidPhoneNumberException
     * @throws \UserContacts\Exceptions\NotExistingUserContactsException
     */
    public function patch($id, $data)
    {
        $editedParams = [
            'address' => '',
            'phoneNumber' => ''
        ];

        if (property_exists($data, 'address')) {
            $editedParams['address'] = 'yeeaaaa';
        }

        if (property_exists($data, 'phone_number')) {
            $editedParams['phoneNumber'] = '+3709999';
        }

        $patchedUserContacts = $this->contactsService->patchUserContacts($id, $editedParams);

        return UserContactsEntity::fromUserContactsEntity($patchedUserContacts);

    }
}
