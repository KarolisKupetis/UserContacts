<?php

namespace UserContactsEditorTest\Editor;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use UserDetails\Editor\UserContactsEditor;
use UserDetails\Entity\UserContacts;
use UserDetails\Entity\UserPhoneNumber;
use UserDetails\Service\UserPhoneNumberService;

class UserContactsEditorTest extends TestCase
{
    /** @var UserContactsEditor */
    private $userContactsEditor;

    /** @var EntityManager| MockObject */
    private $entityManager;

    /** @var UserPhoneNumberService */
    private $phoneNumberService;

    protected function setUp()
    {
        $this->entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->phoneNumberService = $this->getMockBuilder(UserPhoneNumberService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userContactsEditor = new UserContactsEditor($this->entityManager,$this->phoneNumberService);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \UserDetails\Exceptions\InvalidPhoneNumberException
     */
    public function testEditUserContacts(): void
    {
        $editedParams = ['address' => 'johns av. 5','phoneNumber'=>['+37000']];
        $userContacts = new UserContacts();
        $userContacts->addPhoneNumber(new UserPhoneNumber());

        $userPhoneNumber = new UserPhoneNumber();

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->phoneNumberService->expects($this->any())
            ->method('createUserPhoneNumberEntity')
            ->willReturn($userPhoneNumber);

        $this->entityManager->expects($this->any())
            ->method('persist');

        $this->entityManager->expects($this->any())
            ->method('remove');

        $editedUserContacts = $this->userContactsEditor->editUserContacts($userContacts, $editedParams);

        $this->assertEquals($editedUserContacts->getAddress(), $editedParams['address']);

        $this->assertEquals($editedUserContacts->getPhoneNumbers()->get(0),$userPhoneNumber);
    }
}