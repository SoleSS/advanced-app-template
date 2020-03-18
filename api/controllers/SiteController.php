<?php
namespace api\controllers;

use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends \yii\rest\Controller
{
    public function actionIndex() {
        return [
            'version' => 1,
        ];
    }

}
