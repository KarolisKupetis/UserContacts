<?php

namespace UserContacts;

class CreateCest
{
    public function _before(\ApiTester $I)
    {

    }

    // tests
    public function tryToTest(\ApiTester $I)
    {

    }

    public function createUserContactsViaAPI(\ApiTester $I)
    {
        $I->haveHttpHeader('Content-type','application/x-www-form-urlencoded');
        $I->sendPOST('/2/contacts', ['address'=>'avenue 11','phone_number'=>'+37000']);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContains(['id'=>7]);
    }
}
