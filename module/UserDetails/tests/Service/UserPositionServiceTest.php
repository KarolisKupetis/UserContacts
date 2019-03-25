<?php


namespace UserContactsServiceTest\Service;


use PHPUnit\Framework\TestCase;
use User\Entity\User;
use User\Service\UserService;
use UserDetails\Creator\UserPositionCreator;
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

    }
}