<?php


namespace UserContactsServiceTest\Service;


use PHPUnit\Framework\TestCase;
use User\Entity\User;
use User\Service\UserService;
use UserContacts\Creator\UserPositionCreator;
use UserContacts\Service\UserPositionService;
use UserContacts\Validator\UserPositionValidator;

class UserPositionServiceTest extends TestCase
{
    /** @var UserPositionService */
    private $userPositionService;

    /** @var UserPositionCreator */
    private $userPositionCreator;

    /** @var UserPositionValidator */
    private $userPositionValidator;

    /** @var UserService */
    private $userService;

    public function setUp()
    {
        $this->userPositionCreator = $this->getMockBuilder(UserPositionCreator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userService = $this->getMockBuilder(UserService::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userPositionValidator = $this->getMockBuilder(UserPositionValidator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userPositionService = new UserPositionService($this->userService, $this->userPositionValidator,
            $this->userPositionCreator);
    }

    public function testAddUserPosition(): void
    {
        $userPositionParams = ['position'=>'CEO', 'userId'=>'5'];
        $expectedId = 5;
        $this->userService->expects($this->once())
            ->method('getById')
            ->willReturn(new User());

        $this->userPositionValidator->expects($this->once())
            ->method('isPositionValid')
            ->willReturn(true);

        $this->userPositionCreator->expects($this->once())
            ->method('insertUserPosition')
            ->willReturn(5);

        $this->userPositionService->addUserPosition($userPositionParams);

        $this->assertEquals($expectedId,5);
    }
}