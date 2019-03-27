<?php


namespace UserContactsCreatorTest\Creator;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use User\Entity\User;
use UserDetails\Creator\UserPositionCreator;
use UserDetails\Entity\UserPosition;

class UserPositionCreatorTest extends TestCase
{
    /** @var UserPositionCreator */
    private $userPositionCreator;

    /** @var EntityManager|MockObject */
    private $entityManager;

    protected function setUp()
    {
        $this->entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userPositionCreator = new UserPositionCreator($this->entityManager);
    }


    public function testCreateUserPosition(): void
    {
        $position = 'CEO';
        $id = 5;

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->entityManager->expects($this->once())->method('persist')
            ->with($this->callback(function (UserPosition $userPosition) {
                $userPosition->setId(5);
                return true;
            }));

        $newUserPosition = $this->userPositionCreator->createUserPosition($position);

        $this->assertEquals(5, $newUserPosition->getId());
    }
}