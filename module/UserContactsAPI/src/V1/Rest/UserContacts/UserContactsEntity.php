<?php

namespace UserContactsAPI\V1\Rest\UserContacts;

use UserContacts\Entity\UserContacts;

class UserContactsEntity
{
    private $id;
    private $address;
    private $phoneNumber;
    private $userId;

    public static function fromUserContactsEntity(UserContacts $userContacts):array
    {
        $apiEntity = new self();
        $apiEntity->userId = $userContacts->getUser()->getId();
        $apiEntity->phoneNumber = $userContacts->getPhoneNumber();
        $apiEntity->id = $userContacts->getId();
        $apiEntity->address = $userContacts->getAddress();

        return $apiEntity->getArrayCopy();
    }

    public function getArrayCopy():array
    {
        $array = [
            'id' => $this->id,
            'address' => $this->address,
            'phoneNumber' => $this->phoneNumber,
            'userId' => $this->userId,
        ];

        return $array;

    }


}
