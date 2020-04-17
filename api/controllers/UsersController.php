<?php
namespace api\controllers;

use common\models\User;


/**
 * Users controller
 */
class UsersController extends BaseRestWithAuthController
{
    public function actionMyInfo () {
        $model = User::findOne(\Yii::$app->user->id);

        return $model->restArray();
    }

    public function actionInfo (int $id) {
        $model = User::findOne($id);

        return $model->restArray();
    }
}
