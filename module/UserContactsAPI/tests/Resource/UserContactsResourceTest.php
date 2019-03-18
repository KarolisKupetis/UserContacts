<?php

namespace UserContactsAPI\Resource;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use UserContacts\Service\UserContactsService;
use UserContactsAPI\V1\Rest\Usercontacts\UsercontactsResource;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Router\RouteMatch;
use ZF\Rest\ResourceEvent;

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

    public function testUserContactsResource(): void
    {
        $userContactsId = 5;

        $event = new ResourceEvent('create');
//        $inputFilter = new InputFilter();
//        $address = new Input('address');
//        $phoneNumber = new Input('phone_number');
//        $inputFilter->add($address);
//        $inputFilter->add($phoneNumber);
//        $event->setInputFilter($inputFilter);

        $data = new \stdClass();
        $data->address = 'avenue';
        $data->phone_number = '5555';
        $event->setParam('data', $data);
        $event->setRouteMatch(new RouteMatch(['id' => 2]));

        $this->userContactsService->expects($this->once())
            ->method('createUserContacts')
            ->willReturn($userContactsId);

        $result = $this->userContactsResource->dispatch($event);

        $this->assertEquals($userContactsId, $result['id']);
    }
}