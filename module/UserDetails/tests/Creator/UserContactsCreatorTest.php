<?php

namespace UserContactsCreatorTest\Creator;

use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use User\Service\UserService;
use UserDetails\Creator\UserContactsCreator;
use UserDetails\Entity\UserContacts;
use User\Entity\User;

class UserContactsCreatorTest extends TestCase
{
    /** @var UserContactsCreator */
    private $userContactsCreator;

    /** @var EntityManager|MockObject */
    private $entityManager;

    /** @var UserService */
    private $userService;

    protected function setUp()
    {
        $this->entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userService = $this->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();


        $this->userContactsCreator = new UserContactsCreator($this->entityManager,$this->userService);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function testInsertUserContacts(): void
    {
        $user = new User();

        $params = ['phoneNumber' => '8666', 'address' => 'Test av. 1', 'id'=>5];
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
}