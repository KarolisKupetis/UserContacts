<?php


namespace UserContacts\Validator;


class UserPositionValidator
{
    public function isPositionValid(?string $position):bool
    {
        return !($position  === ''||$position===null);
    }
}