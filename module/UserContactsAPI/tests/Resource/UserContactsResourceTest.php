<?php

namespace UserContactsAPI\Resource;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use UserContacts\Service\UserContactsService;
use UserContactsAPI\V1\Rest\Usercontacts\UsercontactsResource;

class UserContactsResourceTest extends TestCase
{
    /** @var UserContactsService|MockObject */
    private $userContactsService;

    /** @var UsercontactsResource */
    private $userContactsResource;

    protected function setUp()
    {
        $this->userContactsService = $this->getMockBuilder(UserContactsService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userContactsResource = new UsercontactsResource($this->userContactsService);
    }

    public function testUserContactsResource():void
    {

    }
}