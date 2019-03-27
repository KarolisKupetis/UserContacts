<?php

namespace UserContactsCreatorTest\Creator;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use User\Service\UserService;
use UserDetails\Creator\UserContactsCreator;
use UserDetails\Entity\UserContacts;
use User\Entity\User;
use UserDetails\Entity\UserPhoneNumber;
use UserDetails\Service\UserPhoneNumberService;

class UserContactsCreatorTest extends TestCase
{
    /** @var UserContactsCreator */
    private $userContactsCreator;

    /** @var EntityManager|MockObject */
    private $entityManager;

    /** @var UserService */
    private $userService;

    /** @var UserPhoneNumberService */
    private $phoneNumberSerivce;


    protected function setUp()
    {
        $this->entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userService = $this->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->phoneNumberSerivce = $this->getMockBuilder(UserPhoneNumberService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userContactsCreator = new UserContactsCreator($this->entityManager, $this->userService, $this->phoneNumberSerivce);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testInsertUserContacts(): void
    {
        $user = new User();

        $params = ['phoneNumbers' => '8666', 'address' => 'Test av. 1', 'id' => 5];
        $user->setId(1);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->entityManager->expects($this->once())->method('persist')
            ->with($this->callback(function (UserContacts $contacts) {
                $contacts->setId(5);
                return true;
            }));

        $this->userService->expects($this->once())
            ->method('getById')
            ->willReturn($user);

        $newUserContact = $this->userContactsCreator->insertUserContacts($params);
        $this->assertEquals(5, $newUserContact->getId());
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \UserDetails\Exceptions\InvalidPhoneNumberException
     */
    public function testAddPhoneNumbersToUserContacts():void
    {
        $phoneNumbers = ['370006'];
        $userContacts = new UserContacts();
        $phoneNumberEntity = new UserPhoneNumber();

        $phoneNumberEntity->setPhoneNumber('+370006');

        $this->entityManager->expects($this->once())
            ->method('persist');

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->phoneNumberSerivce->expects($this->once())
            ->method('createUserPhoneNumberEntity')
            ->willReturn($phoneNumberEntity);

        $this->assertEquals($userContacts,$this->userContactsCreator->addPhoneNumbersToUserContacts($phoneNumbers,$userContacts));
    }

}