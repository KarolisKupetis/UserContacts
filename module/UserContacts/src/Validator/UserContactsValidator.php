<?php

namespace UserContacts\Validator;

class UserContactsValidator
{
    public function isValidPhoneNumber($phoneNumber):bool
    {
        preg_match('((^86[0-9]{8}$)|(^\+3706[0-9]*$))',$phoneNumber,$match);

        if (!$match)
        {
            return false;
        }

        return true;
    }
}

//(^86[0-9]{8}$) nacionaliniams mob.
//