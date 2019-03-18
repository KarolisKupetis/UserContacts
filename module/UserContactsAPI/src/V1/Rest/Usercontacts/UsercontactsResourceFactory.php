<?php
namespace UserContactsAPI\V1\Rest\Usercontacts;

use Psr\Container\ContainerInterface;
use UserContacts\Service\UserContactsService;

class UsercontactsResourceFactory
{
    public function __invoke(ContainerInterface $services)
    {
        /** @var  $UserContactsService */
        $UserContactsService = $services->get(UserContactsService::class);

        return new UsercontactsResource($UserContactsService);
    }
}
