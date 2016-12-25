<?php

namespace app\controllers;

use yii\rest\ActiveController;

/**
 * Abstract API controller with authenticator behaviour.
 *
 * @package app\controllers
 */
abstract class ApiController extends ActiveController
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" action
        unset($actions['delete']);

        return $actions;
    }
}
