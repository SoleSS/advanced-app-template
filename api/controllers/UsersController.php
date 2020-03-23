<?php
namespace api\controllers;

use common\models\User;


/**
 * Users controller
 */
class UsersController extends \yii\rest\Controller
{
    public function actions()
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction',
            ],
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Allow-Origin' => false,
                'Access-Control-Allow-Credentials' => false,
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
            ],
        ];

        $behaviors['authenticator']['class'] = \sizeg\jwt\JwtHttpBearerAuth::class;
        $behaviors['authenticator']['except'] = ['options'];


        return $behaviors;
    }

    public function actionMyInfo () {
        $model = User::findOne(\Yii::$app->user->id);

        return $model->restArray();
    }

    public function actionInfo (int $id) {
        $model = User::findOne($id);

        return $model->restArray();
    }
}
