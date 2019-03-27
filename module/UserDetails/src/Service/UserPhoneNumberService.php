<?php


namespace UserDetails\Service;

use UserDetails\Entity\UserPhoneNumber;
use UserDetails\Exceptions\InvalidPhoneNumberException;
use UserDetails\UserPhoneNumber\UserPhoneNumberCreator;
use UserDetails\Validator\UserContactsValidator;

class UserPhoneNumberService
{
    /** @var UserPhoneNumberCreator */
    private $UserPhoneNumberCreator;

    /** @var UserContactsValidator */
    private $validator;

    public function __construct(UserPhoneNumberCreator $phoneNumberCreator, UserContactsValidator $validator)
    {
        $this->UserPhoneNumberCreator = $phoneNumberCreator;
        $this->validator = $validator;
    }

    /**
     * @param string $phoneNumber
     *
     * @return UserPhoneNumber|null
     * @throws InvalidPhoneNumberException
     * @throws \Doctrine\ORM\ORMException
     */
    public function createUserPhoneNumberEntity(string $phoneNumber): ?UserPhoneNumber
    {
        if ($this->validator->isValidPhoneNumber($phoneNumber)) {
            return $this->UserPhoneNumberCreator->createPhoneNumber($phoneNumber);
        }

        throw new InvalidPhoneNumberException('Invalid phone number');
    }
}