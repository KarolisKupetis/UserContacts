<?php

namespace UserContactsAPI\V1\Rest\UserContacts;

use UserDetails\Entity\UserContacts;

class UserContactsEntity
{
    public $id;
    public $address;
    public $phoneNumber;
    public $userId;

    public static function fromUserContactsEntity(UserContacts $userContacts):UserContactsEntity
    {
        $apiEntity = new self();
        $apiEntity->userId = $userContacts->getUser()->getId();
        $apiEntity->phoneNumber = $userContacts->getPhoneNumber();
        $apiEntity->id = $userContacts->getId();
        $apiEntity->address = $userContacts->getAddress();

        return $apiEntity;
    }
}
