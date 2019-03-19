<?php

class UserContactsCest
{
    public function _before(AcceptanceTester $I)
    {

    }

    public function testUserContactsPOST(AcceptanceTester $I)
    {
        $I->haveHttpHeader('Content-type', 'application/problem+json');
        $I->haveHttpHeader('Accept', '*/*');
        $I->sendPOST('/company/users/2/contacts', ['address' => 'avenue 11', 'phone_number' => '+37000']);
        $I->seeInDatabase('user_contacts',['address'=>'avenue 11','phone_number'=>'+37000','user_id'=>'2']);
        $I->seeResponseEquals('{"id":15}');
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::CREATED);
    }
}
