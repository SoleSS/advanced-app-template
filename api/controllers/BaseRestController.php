<?php
namespace api\controllers;


class BaseRestController extends \yii\rest\Controller
{
    private $_verbs = ['POST','OPTIONS'];

    public function actionOptions ()
    {
        if (Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
            Yii::$app->getResponse()->setStatusCode(405);
        }
        $options = $this->_verbs;
        Yii::$app->getResponse()->getHeaders()->set('Allow', implode(', ', $options));
    }

    public function runAction($id, $params = [])
    {
        // Подменить action если запрос типа OPTIONS
        if ('OPTIONS' === \Yii::$app->request->getMethod())
        {
            return parent::runAction('options', $params);
        } else
        {
            return parent::runAction($id, $params);
        }
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['authenticator']);

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
            'cors' => [
                'Origin'                                => ['*'],
                'Access-Control-Allow-Origin'           => ['*'],
                'Access-Control-Allow-Credentials'      => false,
                'Access-Control-Request-Method'         => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers'        => ['*'],
                'Access-Control-Max-Age'                => 60,
            ],
        ];

        return $behaviors;
    }
}
