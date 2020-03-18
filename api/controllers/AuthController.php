<?php
namespace api\controllers;

use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Auth controller
 */
class AuthController extends \yii\rest\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::className(),
                'rules' => [
                    ['allow' => true, 'actions' => ['gen-jwt-token', ], 'roles' => ['?']],
                    ['allow' => true, 'actions' => ['gen-jwt-token', ], 'roles' => ['@']],
                ],
            ],
            'verbs' => [
                'class' => \yii\filters\VerbFilter::className(),
                'actions' => [
                    'login' => ['post'],
                    'logout' => ['post'],
                    'password-reset-request' => ['post'],
                    'gen-jwt-token' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action) {
        if ($action->id == 'gen-jwt-token') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function actionGenJwtToken() {
        $data = \Yii::$app->getRequest()->post();

        if (!isset($data['login']) || !isset($data['password']))
            throw new BadRequestHttpException();

        $finder = \Yii::createObject(\dektrium\user\Finder::className());
        $loginForm = new \dektrium\user\models\LoginForm($finder, ['login' => $data['login'], 'password' => $data['password']]);
        if ($loginForm->login()) {
            /** @var \common\models\User $identity */
            $identity = \Yii::$app->user->identity;
            $signer = new \Lcobucci\JWT\Signer\Hmac\Sha256();
            $token = \Yii::$app->jwt->getBuilder()
                ->setIssuer(\Yii::$app->params['jwt']['Issuer']) // Configures the issuer (iss claim)
                ->setAudience(\Yii::$app->params['jwt']['Audience']) // Configures the audience (aud claim)
                ->setId(\Yii::$app->params['jwt']['Id'], true) // Configures the id (jti claim), replicating as a header item
                ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
                ->setNotBefore(time() + 0) // Configures the time before which the token cannot be accepted (nbf claim)
                ->setExpiration(time() + 10800) // Configures the expiration time of the token (exp claim)
                ->set('uid', $identity->id) // Configures a new claim, called "uid"
                ->set('uname', $identity->username)
                ->sign($signer, \Yii::$app->jwt->key)
                ->getToken(); // Retrieves the generated token

            return [
                'jti' => $token->getHeader('jti'), // will print "4f1g23a12aa"
                'iss' => $token->getClaim('iss'), // will print "http://example.com"
                'uid' => $token->getClaim('uid'), // will print "1"
                'token' => $token->__toString(), // The string representation of the object is a JWT string (pretty easy, right?)
            ];
        }

        throw new \yii\web\UnauthorizedHttpException();
    }

}
