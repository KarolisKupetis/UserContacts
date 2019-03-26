<?php


namespace UserContactsCreatorTest\Creator;


use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use UserDetails\UserPhoneNumber\UserPhoneNumberCreator;

class UserPhoneNumberCreatorTest extends TestCase
{
    /** @var UserPhoneNumberCreator */
    private $userPhoneNumberCreator;

    /** @var EntityManager|MockObject */
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userPhoneNumberCreator = new UserPhoneNumberCreator($this->entityManager);
    }

    /**
     * @throws \Doctrine\ORM\ORMException
     */
    public function testCreateUserPhoneNumberEntity(): void
    {
        $phoneNumber = '+3706488';

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->willReturn(null);
        $returnedUserPhoneNumber = $this->userPhoneNumberCreator->createPhoneNumber($phoneNumber);

        $this->assertEquals($phoneNumber, $returnedUserPhoneNumber->getPhoneNumber());

    }
}