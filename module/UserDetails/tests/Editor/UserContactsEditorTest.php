<?php

namespace UserContactsEditorTest\Editor;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use UserDetails\Editor\UserContactsEditor;
use UserDetails\Entity\UserContacts;

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
    public function testEditUserContacts(): void
    {
        $editedParams = ['address' => 'johns av. 5'];
        $userContacts = new UserContacts();

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->entityManager->expects($this->once())
            ->method('persist');

        $editedUserContacts = $this->userContactsEditor->editUserContacts($userContacts, $editedParams);

        $this->assertEquals($editedUserContacts->getAddress(), $editedParams['address']);
    }
}