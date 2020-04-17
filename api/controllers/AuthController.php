<?php
namespace api\controllers;

use common\models\User;
use dektrium\user\Finder;
use dektrium\user\Mailer;
use api\models\Token;
use yii\web\BadRequestHttpException;
/**
 * Auth controller
 */
class AuthController extends BaseRestController
{
    private function getJwtToken(User $identity) {
        $signer = new \Lcobucci\JWT\Signer\Hmac\Sha256();
        $expiration = time() + 10800;
        $token = \Yii::$app->jwt->getBuilder()
            ->setIssuer(\Yii::$app->params['jwt']['Issuer']) // Configures the issuer (iss claim)
            ->setAudience(\Yii::$app->params['jwt']['Audience']) // Configures the audience (aud claim)
            ->setId(\Yii::$app->params['jwt']['Id'], true) // Configures the id (jti claim), replicating as a header item
            ->setIssuedAt(time()) // Configures the time that the token was issue (iat claim)
            ->setNotBefore(time() + 0) // Configures the time before which the token cannot be accepted (nbf claim)
            ->setExpiration($expiration) // Configures the expiration time of the token (exp claim)
            ->set('uid', $identity->id) // Configures a new claim, called "uid"
            ->set('uname', $identity->username)
            ->sign($signer, \Yii::$app->jwt->key)
            ->getToken(); // Retrieves the generated token

        return [
            'jti' => $token->getHeader('jti'),
            'iss' => $token->getClaim('iss'),
            'uid' => $token->getClaim('uid'),
            'token' => $token->__toString(),
            'expiration' => $expiration,
            'roles' => array_keys(\Yii::$app->authManager->getRoles()),
            'username' => $identity->username,
            'email' => $identity->email,
            'profile' => $identity->profile,
        ];
    }

    public function actionGenJwtToken() {
        $data = \Yii::$app->getRequest()->post();

        if (!isset($data['username']) || !isset($data['password']))
            throw new BadRequestHttpException();

        $finder = \Yii::createObject(\dektrium\user\Finder::className());
        $loginForm = new \dektrium\user\models\LoginForm($finder, ['login' => $data['username'], 'password' => $data['password']]);
        if ($loginForm->login()) {
            /** @var \common\models\User $identity */
            $identity = \Yii::$app->user->identity;

            return $this->getJwtToken($identity);
        }

        throw new \yii\web\UnauthorizedHttpException();
    }


    public function actionChangePassword() {
        $data = \Yii::$app->getRequest()->post();

        if (!isset($data['username']) || !isset($data['old_password'])|| !isset($data['new_password']))
            throw new BadRequestHttpException();

        $finder = \Yii::createObject(\dektrium\user\Finder::className());
        $loginForm = new \dektrium\user\models\LoginForm($finder, ['login' => $data['username'], 'password' => $data['old_password']]);
        if ($loginForm->login()) {
            /** @var \common\models\User $identity */
            $identity = \Yii::$app->user->identity;

            $identity->password_hash = \dektrium\user\helpers\Password::hash($data['new_password']);
            if (!$identity->save()) {
                return $identity->errors;
            }

            return $this->getJwtToken($identity);
        }

        throw new \yii\web\UnauthorizedHttpException();
    }


    public function actionRecoverPassword () {
        $data = \Yii::$app->getRequest()->post();

        if (!isset($data['email']))
            throw new BadRequestHttpException();

        $user = \common\models\User::findOne(['email' => $data['email']]);
        if ($user === null)
            throw new BadRequestHttpException();

        $token = \Yii::createObject([
            'class' => Token::className(),
            'user_id' => $user->id,
            'type' => Token::TYPE_RECOVERY,
        ]);

        if (!$token->save(false)) {
            return [
                'name' => 'Error',
                'message' => '',
                'code' => 0,
                'status' => 500,
                'type' => null,
            ];
        }

        $mailer = new Mailer();
        if (!$mailer->sendRecoveryMessage($user, $token)) {
            return [
                'name' => 'Error',
                'message' => '',
                'code' => 0,
                'status' => 500,
                'type' => null,
            ];
        }

        return [
            'name' => 'Operation successfully finished',
            'message' => '',
            'code' => 0,
            'status' => 200,
            'type' => null,
        ];
    }

}
