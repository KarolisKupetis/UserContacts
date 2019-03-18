<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use UserContacts\Repository\UserContactsRepository;
use UserContacts\Creator\UserContactsCreator;
use Users\Service\UserService;
use UserContacts\Service\UserContactsService;
use UserContacts\Entity\UserContacts;

class UserContactsServiceTest extends TestCase
{
    /** @var UserContactsRepository|MockObject */
    private $userContactsRepository;

    /** @var UserContactsCreator|MockObject */
    private $userContactsCreator;

    /** @var UserService|MockObject */
    private $userService;

    /** @var UserContactsService */
    private $userContactsService;

    protected function setUp()
    {
        $this->userContactsRepository = $this->getMockBuilder(UserContactsRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userContactsCreator = $this->getMockBuilder(UserContactsCreator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userService = $this->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userContactsService = new UserContactsService($this->userContactsRepository,$this->userContactsCreator,$this->userService);
    }

    public function testCreateUserContacts():void
    {
        $userContactsId = 5;

        $this->userService->expects($this->once())
            ->method('getById')
            ->willReturn(new \Users\Entity\Users());

        $this->userContactsRepository->expects($this->once())
            ->method('findByUserId');

        $this->userContactsCreator->expects($this->once())
            ->method('insertUserContacts')
            ->willReturn($userContactsId);

        $userContactsParam = ['id'=>5,'address'=>'test','phoneNumber'=>8666];

        $this->assertEquals(5,$this->userContactsService->createUserContacts($userContactsParam));
    }

    public function testCreateUserContactsThrowsExceptionOnDuplicateUserContacts():void
    {
        $this->userService->expects($this->once())
            ->method('getById');

        $this->userContactsRepository->expects($this->once())
            ->method('findByUserId')
            ->willReturn(new UserContacts());

        $this->userContactsCreator->expects($this->never())
            ->method('insertUserContacts');

        $userContactsParam = ['id'=>5,'address'=>'test','phoneNumber'=>8666];

        $this->expectException(\UserContacts\Exceptions\ExistingUserContactsException::class);

        $this->userContactsService->createUserContacts($userContactsParam);

    }
}