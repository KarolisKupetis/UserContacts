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
        $I->sendPOST('/company/users/2/contacts', ['address' => 'avenue 11','phoneNumber'=>['+37000']]);
        $I->seeInDatabase('user_contacts', ['address' => 'avenue 11', 'user_id' => '2']);
        $I->seeResponseEquals('{"id":1,"address":"avenue 11","userId":2,"phoneNumber":["+37000"]}');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
    }


    public function patchUserContactsAddress(AcceptanceTester $I):void
    {
        $I->haveInDatabase('user_contacts', ['id'=>'15', 'address' => 'WorstStreet 1', 'user_id' => '2']);
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPATCH('/company/users/2/contacts/15', ['address' => 'BestStreet 2']);
        $I->seeInDatabase('user_contacts',['address'=>'BestStreet 2','user_id'=>'2',]);
        $I->seeResponseEquals('{"id":15,"address":"BestStreet 2","userId":2,"phoneNumber":null}');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
    }


    public function patchUserContactsPhoneNumbers(AcceptanceTester $I):void
    {
        $I->haveInDatabase('user_contacts', ['id'=>'15', 'address' => 'WorstStreet 1', 'user_id' => '2']);
        $I->haveInDatabase('phone_numbers',['id'=>'1','phone_number'=>'+37005','userContacts_id'=>'15']);
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPATCH('/company/users/2/contacts/15', ['address' => 'BestStreet 2','phoneNumber'=>['+37001']]);
        $I->seeInDatabase('phone_numbers',['id'=>'2','phone_number'=>'+37001','userContacts_id'=>'15']);
        $I->seeInDatabase('user_contacts',['address'=>'BestStreet 2','user_id'=>'2',]);
        $I->seeResponseEquals('{"id":15,"address":"BestStreet 2","userId":2,"phoneNumber":["+37001"]}');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
    }

    public function getUserContacts(AcceptanceTester $I):void
    {
        $I->haveInDatabase('user_contacts', ['id'=>'15', 'address' => 'WorstStreet 1', 'user_id' => '2']);
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendGET('/company/users/2/contacts');
        $I->seeResponseEquals('{"id":15,"address":"WorstStreet 1","userId":2,"phoneNumber":null}');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
    }

    public function insertUserPosition(AcceptanceTester $I):void
    {
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPOST('/company/users/1/position',['position' => 'CEO']);
        $I->seeResponseEquals('{"id":1,"position":"CEO"}');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
    }

    public function insertUserPositionWithExistingPosition(AcceptanceTester $I):void
    {
        $I->haveInDatabase('positions', ['id'=>'1', 'position' => 'CEO']);
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPOST('/company/users/1/position',['position' => 'CEO']);
        $I->seeResponseEquals('{"id":1,"position":"CEO"}');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
    }

}
