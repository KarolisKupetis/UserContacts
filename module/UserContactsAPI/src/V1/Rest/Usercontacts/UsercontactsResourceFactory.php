<?php
namespace UserContactsAPI\V1\Rest\Usercontacts;

class UsercontactsResourceFactory
{
    public function __invoke($services)
    {
        return new UsercontactsResource();
    }
}
