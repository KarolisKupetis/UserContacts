<?php


namespace UserContactsCreatorTest\Creator;

use PHPUnit\Framework\TestCase;
use Doctrine\ORM\EntityManager;
use User\Entity\User;
use UserContacts\Creator\UserPositionCreator;
use UserContacts\Entity\UserPosition;

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


    public function testInsertUserPosition(): void
    {
        $user = new User();
        $params = ['position' => 'CEA', 'userId' => '5'];
        $user->setId(5);

        $this->entityManager->expects($this->once())
            ->method('flush');

        $this->entityManager->expects($this->once())->method('persist')
            ->with($this->callback(function (UserPosition $userPosition) {
                $userPosition->setId(5);
                return true;
            }));

        $newUserPosition = $this->userPositionCreator->insertUserPosition($user, $params);
        $this->assertEquals(5, $newUserPosition->getId());
    }
}