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
        $I->sendGET('/groups/fetch');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->sendGET('/groups/1/fetch');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }

    public function ensureThatCreateWorks(ApiTester $I)
    {
        $I->sendPOST('/groups/create', [
            'name' => $this->faker->jobTitle,
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
    }

    public function ensureThatModifyWorks(ApiTester $I)
    {
        $I->sendPUT('/groups/1/modify', [
            'name' => $this->faker->jobTitle,
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }

    public function ensureThatGroupNameMustBeUnique(ApiTester $I)
    {
        $groupName = $this->faker->jobTitle;

        $I->sendPOST('/groups/create', [
            'name' => $groupName,
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->sendPOST('/groups/create', [
            'name' => $groupName,
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
    }
}
