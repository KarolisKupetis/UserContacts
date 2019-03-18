<?php

namespace UserContactsCreatorTest\Creator;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use UserContacts\Creator\UserContactsCreator;
use UserContacts\Entity\UserContacts;
use Users\Entity\Users;

class UserContactsCreatorTest extends TestCase
{
    /** @var UserContactsCreator */
    private $userContactsCreator;

    /** @var EntityManager|MockObject */
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userContactsCreator = new UserContactsCreator($this->entityManager);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testInsertUserContacts(): void
    {
        $user = new Users();
        $params = ['phoneNumber' => '8666', 'address' => 'Test av. 1'];
        $user->setId(1);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->entityManager->expects($this->once())->method('persist')
            ->with($this->callback(function (UserContacts $contacts) {
                $contacts->setId(5);
                return true;
            }));

        $this->assertEquals(5, $this->userContactsCreator->insertUserContacts($user, $params));
    }
}