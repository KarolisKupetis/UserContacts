<?php

namespace UserContactsEditorTest\Editor;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use UserContacts\Editor\UserContactsEditor;
use UserContacts\Entity\UserContacts;

class UserContactsEditorTest extends TestCase
{

    /** @var UserContactsEditor */
    private $userContactsEditor;

    /** @var EntityManager| MockObject */
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userContactsEditor = new UserContactsEditor($this->entityManager);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function testEditUserContacts():void
    {
        $editedParams = ['phoneNumber' => '+370000', 'address' => 'johns av. 5'];
        $userContacts = new UserContacts();

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->entityManager->expects($this->once())
            ->method('persist');

        $editedUserContacts = $this->userContactsEditor->editUserContacts($userContacts, $editedParams);

        $this->assertEquals($editedUserContacts->getPhoneNumber(), $editedParams['phoneNumber']);
        $this->assertEquals($editedUserContacts->getAddress(), $editedParams['address']);
    }
}