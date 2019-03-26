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
        $I->sendPOST('/company/users/2/contacts', ['address' => 'avenue 11']);
        $I->seeInDatabase('user_contacts', ['address' => 'avenue 11', 'user_id' => '2']);
        $I->seeResponseEquals('{"id":1,"address":"avenue 11","userId":2}');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
    }

    public function updateUserContacts(AcceptanceTester $I): void
    {
        $I->haveInDatabase('user_contacts', ['id'=>'15', 'address' => 'avenue 11', 'user_id' => '2']);
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPUT('/company/users/2/contacts/15', ['address' => 'avenue 10']);
        $I->seeInDatabase('user_contacts',['address'=>'avenue 10','user_id'=>'2']);
        $I->seeResponseEquals('{"id":15,"address":"avenue 10","userId":2}');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
    }

    public function failedUpdateUserContactsInvalidAddress(AcceptanceTester $I):void
    {
        $I->haveInDatabase('user_contacts', ['id'=>'15', 'address' => 'WorstStreet 1', 'user_id' => '2']);
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPUT('/company/users/2/contacts/15', ['address' => '']);
        $I->seeInDatabase('user_contacts',['address'=>'WorstStreet 1','user_id'=>'2']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::INTERNAL_SERVER_ERROR);
    }

    public function patchUserContacts(AcceptanceTester $I):void
    {
        $I->haveInDatabase('user_contacts', ['id'=>'15', 'address' => 'WorstStreet 1', 'user_id' => '2']);
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPATCH('/company/users/2/contacts/15', ['address' => 'BestStreet 2']);
        $I->seeInDatabase('user_contacts',['address'=>'BestStreet 2','user_id'=>'2']);
        $I->seeResponseEquals('{"id":15,"address":"BestStreet 2","userId":2}');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
    }

    public function getUserContacts(AcceptanceTester $I):void
    {
        $I->haveInDatabase('user_contacts', ['id'=>'15', 'address' => 'WorstStreet 1', 'user_id' => '2']);
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendGET('/company/users/2/contacts');
        $I->seeResponseEquals('{"id":15,"address":"WorstStreet 1","userId":2}');
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

    public function failedInsertUserPositionUserAlreadyHasPosition(AcceptanceTester $I):void
    {
        $I->haveInDatabase('positions', ['id'=>'1', 'position' => 'CEO']);
        $I->haveInDatabase('users_position',['position_id'=>1,'user_id'=>'1']);
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPOST('/company/users/1/position',['position' => 'CEO']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::INTERNAL_SERVER_ERROR);
    }
}
