<?php

namespace UserContactsAPI\V1\Rest\UserContacts;

use UserDetails\Entity\UserContacts;

class UserContactsEntity
{
    public $id;
    public $address;
    public $userId;
    public $phoneNumber;

    public static function fromUserContactsEntity(UserContacts $userContacts):UserContactsEntity
    {
        $apiEntity = new self();
        $apiEntity->userId = $userContacts->getUser()->getId();
        $apiEntity->id = $userContacts->getId();
        $apiEntity->address = $userContacts->getAddress();
        $phoneNums = $userContacts->getPhoneNumbers();

        foreach ($phoneNums as $number)
        {
            $apiEntity->phoneNumber[] = $number->getPhoneNumber();
        }

        return $apiEntity;
    }
}
