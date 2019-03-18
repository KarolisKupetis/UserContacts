<?php

namespace UserContactsAPI\V1\Rest\Usercontacts;

use UserContacts\Service\UserContactsService;
use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class UsercontactsResource extends AbstractResourceListener
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
     * @return mixed|void|ApiProblem
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function create($data)
    {
        $userContactParams['id'] = $this->getEvent()->getRouteMatch()->getParam('id');
        $userContactParams['address'] = $data->adress;
        $userContactParams['phoneNumber'] = $data->phone_number;
        $this->contactsService->createUserContacts($userContactParams);

        return null;
    }
}
