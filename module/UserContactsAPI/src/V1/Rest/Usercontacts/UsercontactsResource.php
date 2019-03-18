<?php

namespace UserContactsAPI\V1\Rest\Usercontacts;

use Doctrine\ORM\NonUniqueResultException;
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
     * @return int|mixed|ApiProblem
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function create($data)
    {
        $userContactParams['id'] = $this->getEvent()->getRouteMatch()->getParam('id');
        $userContactParams['address'] = $data->address;
        $userContactParams['phoneNumber'] = $data->phone_number;
        $userContactsId = $this->contactsService->createUserContacts($userContactParams);

        return ['id' => $userContactsId];
    }
}
