<?php

namespace UserContactsAPI\V1\Rest\UserContacts;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use User\Entity\User;
use UserDetails\Entity\UserContacts;
use UserDetails\Service\UserContactsService;
use Zend\Router\RouteMatch;
use ZF\Rest\ResourceEvent;

class UserContactsResourceTest extends TestCase
{
    /** @var UserContactsService|MockObject */
    private $userContactsService;

    /** @var UserContactsResource */
    private $userContactsResource;

    protected function setUp()
    {
        $this->userContactsService = $this->getMockBuilder(UserContactsService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userContactsResource = new UserContactsResource($this->userContactsService);
    }

    public function testUserContactsResource(): void
    {
        $user = new User();
        $user->setId('5');

        $userContacts = new UserContacts();
        $userContacts->setId('5');
        $userContacts->setAddress('avenue 11');
        $userContacts->setUser($user);

        $userContactsAPIEntity = new UserContactsEntity();
        $userContactsAPIEntity->address = 'avenue 11';
        $userContactsAPIEntity->userId = 5;
        $userContactsAPIEntity->id = 5;

        $event = new ResourceEvent('create');
        $data = new \stdClass();
        $data->address = 'avenue';
        $data->phoneNumber = ['+3706'];
        $event->setParam('data', $data);
        $event->setRouteMatch(new RouteMatch(['id' => 2]));

        $this->userContactsService->expects($this->once())
            ->method('createUserContacts')
            ->willReturn($userContacts);

        $result = $this->userContactsResource->dispatch($event);

        $this->assertEquals($result, $userContactsAPIEntity);
    }

    public function testUpdate(): void
    {
        $user = new User();
        $user->setId('5');

        $userContacts = new UserContacts();
        $userContacts->setId('5');
        $userContacts->setAddress('avenue 11');
        $userContacts->setUser($user);

        $userContactsAPIEntity = new UserContactsEntity();
        $userContactsAPIEntity->address = 'avenue 11';
        $userContactsAPIEntity->userId = 5;
        $userContactsAPIEntity->id = 5;

        $event = new ResourceEvent('update');
        $data = new \stdClass();
        $data->address = 'avenue';
        $data->phoneNumber = ['+3706'];
        $event->setParam('id', 5);
        $event->setParam('data', $data);

        $event->setRouteMatch(new RouteMatch(['id' => 2]));

        $this->userContactsService->expects($this->once())
            ->method('editUserContacts')
            ->willReturn($userContacts);

        $result = $this->userContactsResource->dispatch($event);

        $this->assertEquals($result, $userContactsAPIEntity);
    }

    public function testPatch()
    {
        $user = new User();
        $user->setId('5');

        $userContacts = new UserContacts();
        $userContacts->setId('5');
        $userContacts->setAddress('avenue 11');
        $userContacts->setUser($user);

        $userContactsAPIEntity = new UserContactsEntity();
        $userContactsAPIEntity->address = 'avenue 11';
        $userContactsAPIEntity->userId = 5;
        $userContactsAPIEntity->id = 5;

        $event = new ResourceEvent('patch');
        $data = new \stdClass();
        $data->address = 'avenue';
        $data->phoneNumber = ['+3706'];
        $event->setParam('id', 5);
        $event->setParam('data', $data);

        $event->setRouteMatch(new RouteMatch(['id' => 2]));

        $this->userContactsService->expects($this->once())
            ->method('updateSeparateUserContactsParams')
            ->willReturn($userContacts);

        $result = $this->userContactsResource->dispatch($event);

        $this->assertEquals($result, $userContactsAPIEntity);
    }

    public function testFetchAll()
    {
        $user = new User();
        $user->setId('5');

        $userContacts = new UserContacts();
        $userContacts->setId('5');
        $userContacts->setAddress('avenue 11');
        $userContacts->setUser($user);

        $userContactsAPIEntity = new UserContactsEntity();
        $userContactsAPIEntity->address = 'avenue 11';
        $userContactsAPIEntity->userId = 5;
        $userContactsAPIEntity->id = 5;

        $event = new ResourceEvent('fetchAll');
        $data = new \stdClass();
        $data->address = 'avenue';
        $data->phoneNumber = ['+3706'];
        $event->setParam('id', 5);
        $event->setParam('data', $data);

        $event->setRouteMatch(new RouteMatch(['id' => 2]));

        $this->userContactsService->expects($this->once())
            ->method('getUserContactsByUserId')
            ->willReturn($userContacts);

        $result = $this->userContactsResource->dispatch($event);

        $this->assertEquals($result, $userContactsAPIEntity);
    }
}