<?php
namespace UserContactsAPI\V1\Rest\UserPosition;

use UserDetails\Entity\UserPosition;

class UserPositionEntity
{
    /** @var int */
    public $id;
    public $position;

    public static function fromPositionEntity(UserPosition $position):UserPositionEntity
    {
        $apiEntity = new self();
        $apiEntity->id = $position->getId();
        $apiEntity->position = $position->getPosition();

        return $apiEntity;
    }
}
