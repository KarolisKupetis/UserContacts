<?php

namespace UserContactsAPI\V1\Rest\UserContacts;

use UserContacts\Entity\UserContacts;

class UserContactsEntity
{
    private $id;
    private $address;
    private $phoneNumber;
    private $userId;

    public static function fromUserContactsEntity(UserContacts $userContacts):UserContactsEntity
    {
        $apiEntity = new self();
        $apiEntity->userId = $userContacts->getId();
        $apiEntity->phoneNumber = $userContacts->getPhoneNumber();
        $apiEntity->id = $userContacts->getUser()->getId();
        $apiEntity->address = $userContacts->getAddress();

        return $apiEntity;
    }

}
