<?php
namespace UserContactsAPI\V1\Rest\UserPosition;

use Psr\Container\ContainerInterface;
use UserContacts\Service\UserPositionService;

class UserPositionResourceFactory
{
    public function __invoke(ContainerInterface $services)
    {
        /** @var  $userPositionService */
        $userPositionService = $services->get(UserPositionService::class);

        return new UserPositionResource($userPositionService);
    }
}
