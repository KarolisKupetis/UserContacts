<?php

namespace UserContactsServiceTest\Service;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use UserDetails\Editor\UserContactsEditor;
use UserDetails\Exceptions\EmptyAddressException;
use UserDetails\Exceptions\ExistingUserContactsException;
use UserDetails\Repository\UserContactsRepository;
use UserDetails\Creator\UserContactsCreator;
use UserDetails\Validator\UserContactsValidator;
use User\Service\UserService;
use UserDetails\Service\UserContactsService;
use UserDetails\Entity\UserContacts;

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

        $this->userContactsValidator = $this->getMockBuilder(UserContactsValidator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userContactsEditor = $this->getMockBuilder(UserContactsEditor::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userContactsService = new UserContactsService($this->userContactsRepository, $this->userContactsCreator,
            $this->userContactsValidator, $this->userContactsEditor);
    }

    /**
     * @throws EmptyAddressException
     * @throws ExistingUserContactsException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testCreateUserContacts(): void
    {
        $userContacts = new UserContacts();
        $userContacts->setId(5);

        $this->userContactsValidator->expects($this->once())
            ->method('isValidAddress')
            ->willReturn(true);

        $this->userContactsRepository->expects($this->once())
            ->method('findByUserId');

        $this->userContactsCreator->expects($this->once())
            ->method('insertUserContacts')
            ->willReturn($userContacts);

        $this->userContactsCreator->expects($this->once())
            ->method('addPhoneNumbersToUserContacts')
            ->willReturn($userContacts);

        $userContactsParam = ['id' => 5, 'address' => 'test', 'phoneNumbers' => ['+37000']];

        $newUserContact = $this->userContactsService->createUserContacts($userContactsParam);

        $this->assertEquals(5, $newUserContact->getId());
    }

    /**
     * @throws EmptyAddressException
     * @throws ExistingUserContactsException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testCreateUserContactsExceptionOnDuplicateUserContacts(): void
    {
        $this->userContactsValidator->expects($this->never())
            ->method('isValidAddress')
            ->willReturn(true);

        $this->userContactsRepository->expects($this->once())
            ->method('findByUserId')
            ->willReturn(new UserContacts());

        $this->userContactsCreator->expects($this->never())
            ->method('insertUserContacts');

        $userContactsParam = ['id' => 5, 'address' => 'test', 'phoneNumber' => 8666];

        $this->expectException(ExistingUserContactsException::class);

        $this->userContactsService->createUserContacts($userContactsParam);

    }

    /**
     * @throws EmptyAddressException
     * @throws ExistingUserContactsException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testCreateUserContactsExceptionOnEmptyAddress(): void
    {
        $this->userContactsValidator->expects($this->once())
            ->method('isValidAddress')
            ->willReturn(false);

        $this->userContactsRepository->expects($this->once())
            ->method('findByUserId');

        $this->userContactsCreator->expects($this->never())
            ->method('insertUserContacts');

        $userContactsParam = ['id' => 5, 'address' => 'test', 'phoneNumber' => 8666];

        $this->expectException(EmptyAddressException::class);

        $this->userContactsService->createUserContacts($userContactsParam);
    }

    /**
     * @throws EmptyAddressException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function testEditUserContacts(): void
    {
        $editedParams = ['address' => 'avenue 1'];

        $editedUserContacts = new UserContacts();
        $editedUserContacts->setAddress($editedParams['address']);

        $this->userContactsRepository->expects($this->once())
            ->method('getById')
            ->willReturn(new UserContacts());

        $this->userContactsValidator->expects($this->once())
            ->method('isValidAddress')
            ->willReturn(true);

        $this->userContactsEditor->expects($this->once())
            ->method('editUserContacts')
            ->willReturn($editedUserContacts);

        $returnedUserContacts = $this->userContactsService->editUserContacts(5, $editedParams);

        $this->assertEquals($returnedUserContacts->getAddress(), $editedParams['address']);
    }

    /**
     * @throws EmptyAddressException
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function testEditUserContactsExceptionOnEmptyAddress()
    {
        $editedParams = ['address' => ''];

        $editedUserContacts = new UserContacts();
        $editedUserContacts->setAddress($editedParams['address']);

        $this->userContactsRepository->expects($this->once())
            ->method('getById')
            ->willReturn(new UserContacts());

        $this->userContactsValidator->expects($this->once())
            ->method('isValidAddress')
            ->willReturn(false);

        $this->userContactsEditor->expects($this->never())
            ->method('editUserContacts');


        $this->expectException(EmptyAddressException::class);

        $this->userContactsService->editUserContacts(5, $editedParams);


    }

    /**
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\ORMException
     */
    public function testUpdateSeparateUserContactsParams(): void
    {
        $editedParams = ['address' => ''];

        $preEditedUserContacts = new UserContacts();
        $preEditedUserContacts->setAddress('best street ever');

        $editedUserContacts = new UserContacts();
        $editedUserContacts->setAddress('best street ever');

        $this->userContactsRepository->expects($this->once())
            ->method('getById')
            ->willReturn($preEditedUserContacts);

        $this->userContactsEditor->expects($this->once())
            ->method('editUserContacts')
            ->willReturn($editedUserContacts);

        $returnedUserContacts = $this->userContactsService->updateSeparateUserContactsParams(5, $editedParams);

        $this->assertEquals($returnedUserContacts->getAddress(), $preEditedUserContacts->getAddress());
    }

    public function testGetUserContactsByUserId(): void
    {
        $userContacts = new UserContacts();
        $userContacts->setId(1);

        $this->userContactsRepository->expects($this->once())
            ->method('findByUserID')
            ->willReturn($userContacts);

        $this->assertEquals(1, $this->userContactsService->getUserContactsByUserId(1)->getId());
    }
}