<?php

use Codeception\Util\HttpCode;

class GroupCest
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    public function ensureThatFetchWorks(ApiTester $I)
    {
        $I->sendGET('/groups');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->sendGET('/groups/1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }

    public function ensureThatCreateWorks(ApiTester $I)
    {
        $I->sendPOST('/groups', [
            'name' => $this->faker->jobTitle,
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
    }

    public function ensureThatModifyWorks(ApiTester $I)
    {
        $I->sendPUT('/groups/1', [
            'name' => $this->faker->jobTitle,
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }

    public function ensureThatGroupNameMustBeUnique(ApiTester $I)
    {
        $groupName = $this->faker->jobTitle;

        $I->sendPOST('/groups', [
            'name' => $groupName,
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->sendPOST('/groups', [
            'name' => $groupName,
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
    }

    public function ensureThatDeleteMethodIsNotAllowed(ApiTester $I)
    {
        $I->sendDELETE('/groups/1');
        $I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
    }
}
