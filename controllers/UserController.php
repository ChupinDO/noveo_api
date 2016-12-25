<?php

namespace app\controllers;

use yii\rest\ActiveController;

/**
 * User API controller
 *
 * @package app\controllers
 */
class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';
}
