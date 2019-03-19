<?php

namespace UserContactsServiceTest\Service;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use UserContacts\Editor\UserContactsEditor;
use UserContacts\Exceptions\EmptyAddressException;
use UserContacts\Exceptions\ExistingUserContactsException;
use UserContacts\Exceptions\InvalidPhoneNumberException;
use UserContacts\Repository\UserContactsRepository;
use UserContacts\Creator\UserContactsCreator;
use UserContacts\Validator\UserContactsValidator;
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

    /** @var UserContactsValidator */
    private $userContactsValidator;

    /** @var UserContactsEditor */
    private $userContactsEditor;

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

        $this->userContactsValidator = $this->getMockBuilder(UserContactsValidator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userContactsEditor = $this->getMockBuilder(UserContactsEditor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userContactsService = new UserContactsService($this->userContactsRepository, $this->userContactsCreator,
            $this->userService, $this->userContactsValidator,$this->userContactsEditor);
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function testCreateUserContacts(): void
    {
        $userId = 1;
        $userContactsId = 5;

        $this->userContactsValidator->expects($this->once())
            ->method('isValidPhoneNumber')
            ->willReturn(true);

        $this->userContactsValidator->expects($this->once())
            ->method('isValidAddress')
            ->willReturn(true);

        $this->userService->expects($this->once())
            ->method('getById')
            ->willReturn(new \Users\Entity\Users());

        $this->userContactsRepository->expects($this->once())
            ->method('findByUserId');

        $this->userContactsCreator->expects($this->once())
            ->method('insertUserContacts')
            ->willReturn($userContactsId);

        $userContactsParam = ['id' => 5, 'address' => 'test', 'phoneNumber' => 8666];

        $this->assertEquals(5, $this->userContactsService->createUserContacts($userContactsParam));
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function testCreateUserContactsOnDuplicateUserContacts(): void
    {
        $this->userContactsValidator->expects($this->once())
            ->method('isValidPhoneNumber')
            ->willReturn(true);

        $this->userContactsValidator->expects($this->once())
            ->method('isValidAddress')
            ->willReturn(true);

        $this->userContactsRepository->expects($this->once())
            ->method('findByUserId')
            ->willReturn(new UserContacts());

        $this->userService->expects($this->never())
            ->method('getById');

        $this->userContactsCreator->expects($this->never())
            ->method('insertUserContacts');

        $userContactsParam = ['id' => 5, 'address' => 'test', 'phoneNumber' => 8666];

        $this->expectException(ExistingUserContactsException::class);

        $this->userContactsService->createUserContacts($userContactsParam);

    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function testCreateUserContactsExceptionOnWrongPhoneNumber(): void
    {
        $this->userContactsValidator->expects($this->once())
            ->method('isValidPhoneNumber')
            ->willReturn(false);

        $this->userContactsValidator->expects($this->never())
            ->method('isValidAddress');

        $this->userService->expects($this->never())
            ->method('getById');

        $this->userContactsRepository->expects($this->never())
            ->method('findByUserId');

        $this->userContactsCreator->expects($this->never())
            ->method('insertUserContacts');

        $userContactsParam = ['id' => 5, 'address' => 'test', 'phoneNumber' => 8666];

        $this->expectException(InvalidPhoneNumberException::class);

        $this->userContactsService->createUserContacts($userContactsParam);

    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function testCreateUserContactsExceptionOnEmptyAddress(): void
    {
        $this->userContactsValidator->expects($this->once())
            ->method('isValidPhoneNumber')
            ->willReturn(true);

        $this->userContactsValidator->expects($this->once())
            ->method('isValidAddress')
            ->willReturn(false);

        $this->userService->expects($this->never())
            ->method('getById');

        $this->userContactsRepository->expects($this->never())
            ->method('findByUserId');

        $this->userContactsCreator->expects($this->never())
            ->method('insertUserContacts');

        $userContactsParam = ['id' => 5, 'address' => 'test', 'phoneNumber' => 8666];

        $this->expectException(EmptyAddressException::class);

        $this->userContactsService->createUserContacts($userContactsParam);

    }
}