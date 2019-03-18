<?php

namespace UserContactsValidatorTest\Validator;

use PHPUnit\Framework\TestCase;
use UserContacts\Validator\UserContactsValidator;

class UserContactsValidatorTest extends TestCase
{
    /** @var UserContactsValidator */
    private $userContactsValidator;

    protected function setUp()
    {
        $this->userContactsValidator = new UserContactsValidator();
    }

    public function testValidatorIfTrueWithCorrectNumber(): void
    {
        $phoneNumber = '+37000000';

        $this->assertTrue($this->userContactsValidator->isValidPhoneNumber($phoneNumber));
    }

    public function testValidatorIfFalseWithWrongNumber(): void
    {
        $phoneNumber = '37000000';

        $this->assertFalse($this->userContactsValidator->isValidPhoneNumber($phoneNumber));
    }

    public function testValidatorIfFalseWithOnlyPlusSignAsNumber(): void
    {
        $phoneNumber = '+';

        $this->assertFalse($this->userContactsValidator->isValidPhoneNumber($phoneNumber));
    }

    public function testValidatorIfFalseWithEmptyNumber(): void
    {
        $phoneNumber = '';

        $this->assertFalse($this->userContactsValidator->isValidPhoneNumber($phoneNumber));
    }

    public function testValidatorIfFalseWithEmptyAddress(): void
    {
        $address = '';

        $this->assertFalse($this->userContactsValidator->isValidAddress($address));
    }

    public function testValidatorIfTrueWithAddress(): void
    {
        $address = 'not empty address';

        $this->assertTrue($this->userContactsValidator->isValidAddress($address));
    }

}