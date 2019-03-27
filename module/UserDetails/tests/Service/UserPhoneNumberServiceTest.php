<?php


namespace UserContactsServiceTest\Service;


use PHPUnit\Framework\TestCase;
use UserDetails\Entity\UserPhoneNumber;
use UserDetails\Exceptions\InvalidPhoneNumberException;
use UserDetails\Service\UserPhoneNumberService;
use UserDetails\UserPhoneNumber\UserPhoneNumberCreator;
use UserDetails\Validator\UserContactsValidator;

class UserPhoneNumberServiceTest extends TestCase
{
    /** @var UserPhoneNumberCreator */
    private $userPhoneNumberCreator;

    /** @var UserContactsValidator */
    private $userContactsValidator;

    /** @var UserPhoneNumberService */
    private $userPhoneNumberService;

    protected function setUp()
    {
        $this->userPhoneNumberCreator = $this->getMockBuilder(UserPhoneNumberCreator::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userContactsValidator = $this->getMockBuilder(UserContactsValidator::class)
            ->disableOriginalConstructor()
            ->getMock();


        $this->userPhoneNumberService = new UserPhoneNumberService($this->userPhoneNumberCreator,$this->userContactsValidator);
    }

    /**
     * @throws InvalidPhoneNumberException
     * @throws \Doctrine\ORM\ORMException
     */
    public function testCreateUserPhoneNumberEntity():void
    {
        $this->userContactsValidator->expects($this->once())
            ->method('isValidPhoneNumber')
            ->willReturn(true);

        $this->userPhoneNumberCreator->expects($this->once())
            ->method('createPhoneNumber')
            ->willReturn(new UserPhoneNumber());

        $phoneNumber = '+37000';

        $this->assertEquals(new UserPhoneNumber(),$this->userPhoneNumberService->createUserPhoneNumberEntity($phoneNumber));
    }

    /**
     * @throws InvalidPhoneNumberException
     * @throws \Doctrine\ORM\ORMException
     */
    public function testCreateUserPhoneNumberEntityExceptionOnInvalidNumber():void
    {
        $this->userContactsValidator->expects($this->once())
            ->method('isValidPhoneNumber')
            ->willReturn(false);

        $this->userPhoneNumberCreator->expects($this->never())
            ->method('createPhoneNumber');

        $phoneNumber = '+37';

        $this->expectException(InvalidPhoneNumberException::class);

        $this->assertNull($this->userPhoneNumberService->createUserPhoneNumberEntity($phoneNumber));
    }
}