<?php

namespace UserContactsServiceTest\Service;

use PHPUnit\Framework\TestCase;
use User\Entity\User;
use User\Service\UserService;
use UserDetails\Creator\UserPositionCreator;
use UserDetails\Entity\UserPosition;
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

        $this->userPositionCreator->expects($this->never())
            ->method('createUserPosition');

        $this->userPositionRepository->expects($this->once())
            ->method('findByUser')
            ->willReturn(null);

        $this->userPositionCreator->expects($this->never())
            ->method('removePositionFromUser');

        $this->userPositionCreator->expects($this->once())
            ->method('addPositionToUser')
            ->willReturn($newUserPosition);

        $this->assertEquals($newUserPosition, $this->userPositionService->changeUserPosition($userPositionParams));
    }

    public function testAddUserPositionWithoutExistingPosition(): void
    {
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

        $this->userPositionCreator->expects($this->once())
            ->method('createUserPosition')
            ->willReturn($newUserPosition);

        $this->userPositionRepository->expects($this->once())
            ->method('findByUser')
            ->willReturn(null);

        $this->userPositionCreator->expects($this->never())
            ->method('removePositionFromUser');

        $this->userPositionCreator->expects($this->once())
            ->method('addPositionToUser')
            ->willReturn($newUserPosition);

        $this->assertEquals($newUserPosition, $this->userPositionService->changeUserPosition($userPositionParams));
    }



    public function testChangeUserPositionUserAlreadyHasPosition(): void
    {
        $userPositionParams = ['userId' => 1, 'position' => 'CEO'];
        $newUserPosition = new UserPosition();
        $user = new User();
        $newUserPosition->addUser($user);
        $existingUserPosition = new UserPosition();

        $this->userService->expects($this->once())
            ->method('getById')
            ->willReturn($user);

        $this->userPositionValidator->expects($this->once())
            ->method('isPositionValid')
            ->willReturn(true);

        $this->userPositionRepository->expects($this->once())
            ->method('findByPosition')
            ->willReturn(null);

        $this->userPositionCreator->expects($this->once())
            ->method('createUserPosition')
            ->willReturn($newUserPosition);

        $this->userPositionRepository->expects($this->once())
            ->method('findByUser')
            ->willReturn($existingUserPosition);

        $this->userPositionCreator->expects($this->once())
            ->method('removePositionFromUser');

        $this->userPositionCreator->expects($this->once())
            ->method('addPositionToUser')
            ->willReturn($newUserPosition);

        $this->assertEquals($newUserPosition, $this->userPositionService->changeUserPosition($userPositionParams));
    }
}