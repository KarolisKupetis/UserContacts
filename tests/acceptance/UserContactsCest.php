<?php

class UserContactsCest
{
    public function _before(AcceptanceTester $I)
    {

    }

    public function insertNewUserContacts(AcceptanceTester $I): void
    {
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPOST('/company/users/2/contacts', ['address' => 'avenue 11', 'phoneNumber' => '+37000']);
        $I->seeInDatabase('user_contacts', ['address' => 'avenue 11', 'phone_number' => '+37000', 'user_id' => '2']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
    }

    public function updateUserContacts(AcceptanceTester $I): void
    {
        $I->haveInDatabase('user_contacts', ['id'=>'15', 'address' => 'avenue 11', 'phone_number' => '+37000', 'user_id' => '2']);
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPUT('/company/users/2/contacts/15', ['address' => 'avenue 10', 'phoneNumber' => '+37011']);
        $I->seeInDatabase('user_contacts',['address'=>'avenue 10','phone_number'=>'+37011','user_id'=>'2']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
    }

    public function failedUpdateUserContactsInvalidNumber(AcceptanceTester $I):void
    {
        $I->haveInDatabase('user_contacts', ['id'=>'15', 'address' => 'WorstStreet 1', 'phone_number' => '+37000', 'user_id' => '2']);
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPUT('/company/users/2/contacts/15', ['address' => 'BestStreet 5', 'phoneNumber' => '']);
        $I->seeInDatabase('user_contacts',['address'=>'WorstStreet 1','phone_number'=>'+37000','user_id'=>'2']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::INTERNAL_SERVER_ERROR);
    }

    public function failedUpdateUserContactsInvalidAddress(AcceptanceTester $I):void
    {
        $I->haveInDatabase('user_contacts', ['id'=>'15', 'address' => 'WorstStreet 1', 'phone_number' => '+37000', 'user_id' => '2']);
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPUT('/company/users/2/contacts/15', ['address' => '', 'phoneNumber' => '+37000']);
        $I->seeInDatabase('user_contacts',['address'=>'WorstStreet 1','phone_number'=>'+37000','user_id'=>'2']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::INTERNAL_SERVER_ERROR);
    }

    public function patchUserContacts(AcceptanceTester $I):void
    {
        $I->haveInDatabase('user_contacts', ['id'=>'15', 'address' => 'WorstStreet 1', 'phone_number' => '+37000', 'user_id' => '2']);
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPATCH('/company/users/2/contacts/15', ['address' => 'BestStreet 2']);
        $I->seeInDatabase('user_contacts',['address'=>'BestStreet 2','phone_number'=>'+37000','user_id'=>'2']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
    }
}
