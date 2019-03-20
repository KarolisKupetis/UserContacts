<?php

namespace UserContacts\Validator;

class UserContactsValidator
{
    public function isValidPhoneNumber(string $phoneNumber): bool
    {
        preg_match('/^\+370[\d\s]*$/', $phoneNumber, $match);

        if (!$match) {

            return false;
        }

        return true;
    }

    public function isValidAddress($address): bool
    {
        return !($address === ''||$address===null);
    }
}
