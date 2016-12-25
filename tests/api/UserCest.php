<?php

use Codeception\Util\HttpCode;

class UserCest
{
    private $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    public function ensureThatFetchWorks(ApiTester $I)
    {
        $I->sendGET('/users/fetch');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $I->sendGET('/users/1/fetch');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }

    public function ensureThatCreateWorks(ApiTester $I)
    {
        $I->sendPOST('/users/create', [
            'email'      => $this->faker->email,
            'last_name'  => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'state'      => (int)$this->faker->boolean,
            'group_id'   => 1,
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
    }

    public function ensureThatModifyWorks(ApiTester $I)
    {
        $I->sendPUT('/users/1/modify', [
            'email'      => $this->faker->email,
            'first_name' => $this->faker->firstName,
        ]);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
    }

    public function ensureThatUserHasNotCreatedWithNonExistedGroup(ApiTester $I)
    {
        $I->sendPOST('/users/create', [
            'email'      => $this->faker->email,
            'last_name'  => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'state'      => (int)$this->faker->boolean,
            'group_id'   => 9999, // fake group
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
    }

    public function ensureThatUserEmailMustBeUnique(ApiTester $I)
    {
        $email = $this->faker->email;

        $I->sendPOST('/users/create', [
            'email'    => $email,
            'group_id' => 1,
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();

        $I->sendPOST('/users/create', [
            'email'    => $email,
            'group_id' => 2,
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
    }

    public function ensureThatUserDefaultStateIsInactive(ApiTester $I)
    {
        $I->sendPOST('/users/create', [
            'email'      => $this->faker->email,
            'first_name' => $this->faker->firstName,
            'group_id'   => 1,
        ]);
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }

    public function ensureThatUsersResponseIsCorrect(ApiTester $I)
    {
        $I->sendGET('/users/fetch');
        $I->seeResponseCodeIs(HttpCode::OK);

        $I->seeResponseMatchesJsonType([
            'id'            => 'integer',
            'email'         => 'string:email',
            'first_name'    => 'string|null',
            'last_name'     => 'string|null',
            'state'         => 'integer',
            'creation_date' => 'string:regex(/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/)',
            'group_id'      => 'integer',
        ]);
    }
}
