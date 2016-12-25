<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;

/**
 * Fixtures for User model
 *
 * @package app\tests\fixture
 */
class UserFixture extends ActiveFixture
{
    public $modelClass = 'app\models\User';

    public $depends = ['app\tests\fixtures\GroupFixture'];
}
