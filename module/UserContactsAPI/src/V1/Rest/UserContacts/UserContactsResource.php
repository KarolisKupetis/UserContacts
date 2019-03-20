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
     * @return mixed|UserContactsEntity|ApiProblem
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \UserContacts\Exceptions\EmptyAddressException
     * @throws \UserContacts\Exceptions\InvalidPhoneNumberException
     * @throws \UserContacts\Exceptions\NotExistingUserContacts
     */
    public function update($id, $data)
    {
        $editedParams['address'] = $data->address;
        $editedParams['phoneNumber'] = $data->phone_number;

        $editedUserContacts = $this->contactsService->editUserContacts($id,$editedParams);

        UserContactsEntity::fromUserContactsEntity($editedUserContacts);
    }
}
