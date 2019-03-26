<?php


namespace UserContactsServiceTest\Service;

use PHPUnit\Framework\TestCase;
use User\Entity\User;
use User\Service\UserService;
use UserDetails\Creator\UserPositionCreator;
use UserDetails\Entity\UserPosition;
use UserDetails\Exceptions\UserAlreadyHasPositionException;
use UserDetails\Repository\UserPositionRepository;
use UserDetails\Service\UserPositionService;
use UserDetails\Validator\UserPositionValidator;

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

    /** @var UserPositionRepository */
    private $userPositionRepository;

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

        $this->userPositionRepository = $this->getMockBuilder(UserPositionRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userPositionService = new UserPositionService($this->userPositionCreator, $this->userService,
            $this->userPositionValidator, $this->userPositionRepository);
    }


    public function testAddUserPosition(): void
    {
        $userPositionServiceMock = $this->getMockBuilder(UserPositionService::class)
            ->setConstructorArgs(array(
                $this->userPositionCreator,
                $this->userService,
                $this->userPositionValidator,
                $this->userPositionRepository
            ))
            ->setMethods(array('doesUserHavePosition'))
            ->getMock();


        $userPositionParams = ['userId' => 1, 'position' => 'CEO'];

        $newUserPosition = new UserPosition();
        $user = new User();
        $newUserPosition->addUser($user);

        $this->userService->expects($this->once())
            ->method('getById')
            ->willReturn($user);

        $this->userPositionValidator->expects($this->once())
            ->method('isPositionValid')
            ->willReturn(true);

        $this->userPositionRepository->expects($this->once())
            ->method('findByPosition')
            ->willReturn($newUserPosition);

        $userPositionServiceMock->expects($this->once())
            ->method('doesUserHavePosition')
            ->willReturn(false);

        $this->userPositionCreator->expects($this->once())
            ->method('addUserToPosition')
            ->willReturn($newUserPosition);

        $this->userPositionCreator->expects($this->never())
            ->method('insertUserPosition');

        $this->assertEquals($newUserPosition, $userPositionServiceMock->addUserPosition($userPositionParams));
    }

    public function testAddUserPositionWithoutExistingPosition(): void
    {
        $userPositionServiceMock = $this->getMockBuilder(UserPositionService::class)
            ->setConstructorArgs(array(
                $this->userPositionCreator,
                $this->userService,
                $this->userPositionValidator,
                $this->userPositionRepository
            ))
            ->setMethods(array('doesUserHavePosition'))
            ->getMock();


        $userPositionParams = ['userId' => 1, 'position' => 'CEO'];

        $newUserPosition = new UserPosition();
        $user = new User();
        $newUserPosition->addUser($user);

        $this->userService->expects($this->once())
            ->method('getById')
            ->willReturn($user);

        $this->userPositionValidator->expects($this->once())
            ->method('isPositionValid')
            ->willReturn(true);

        $this->userPositionRepository->expects($this->once())
            ->method('findByPosition')
            ->willReturn(null);

        $userPositionServiceMock->expects($this->never())
            ->method('doesUserHavePosition')
            ->willReturn(false);

        $this->userPositionCreator->expects($this->once())
            ->method('insertUserPosition')
            ->willReturn($newUserPosition);

        $this->userPositionCreator->expects($this->once())
            ->method('addUserToPosition')
            ->willReturn($newUserPosition);

        $this->assertEquals($newUserPosition, $userPositionServiceMock->addUserPosition($userPositionParams));
    }

    public function testAddUserPositionDuplicatePositionException(): void
    {
        $userPositionServiceMock = $this->getMockBuilder(UserPositionService::class)
            ->setConstructorArgs(array(
                $this->userPositionCreator,
                $this->userService,
                $this->userPositionValidator,
                $this->userPositionRepository
            ))
            ->setMethods(array('doesUserHavePosition'))
            ->getMock();


        $userPositionParams = ['userId' => 1, 'position' => 'CEO'];

        $newUserPosition = new UserPosition();
        $user = new User();
        $newUserPosition->addUser($user);

        $this->userService->expects($this->once())
            ->method('getById')
            ->willReturn($user);

        $this->userPositionValidator->expects($this->once())
            ->method('isPositionValid')
            ->willReturn(true);

        $this->userPositionRepository->expects($this->once())
            ->method('findByPosition')
            ->willReturn($newUserPosition);

        $userPositionServiceMock->expects($this->once())
            ->method('doesUserHavePosition')
            ->willReturn(true);

        $this->userPositionCreator->expects($this->never())
            ->method('insertUserPosition');

        $this->userPositionCreator->expects($this->never())
            ->method('addUserToPosition')
            ->willReturn($newUserPosition);

        $this->expectException(UserAlreadyHasPositionException::class);

        $this->assertEquals($newUserPosition, $userPositionServiceMock->addUserPosition($userPositionParams));
    }

    public function testDoesUserHavePositionTrue(): void
    {
        $user = new User();
        $userPosition = new UserPosition();
        $userPosition->addUser($user);

        $this->assertTrue($this->userPositionService->doesUserHavePosition($user, $userPosition));
    }

    public function testDoesUserHavePositionFalse(): void
    {
        $user = new User();
        $userPosition = new UserPosition();

        $this->assertFalse($this->userPositionService->doesUserHavePosition($user, $userPosition));
    }

}