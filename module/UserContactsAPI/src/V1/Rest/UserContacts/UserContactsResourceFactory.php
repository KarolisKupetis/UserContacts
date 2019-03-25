<?php

namespace UserContactsAPI\V1\Rest\UserContacts;

use Psr\Container\ContainerInterface;
use UserDetails\Service\UserContactsService;

class UserContactsResourceFactory
{
    public function __invoke(ContainerInterface $services)
    {
        /** @var  $UserContactsService */
        $UserContactsService = $services->get(UserContactsService::class);

        return new UserContactsResource($UserContactsService);
    }
}
