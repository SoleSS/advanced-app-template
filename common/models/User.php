<?php

namespace common\models;

/**
 * User ActiveRecord model.
 *
 * @property bool    $isAdmin
 * @property bool    $isBlocked
 * @property bool    $isConfirmed
 *
 * Database fields:
 * @property integer $id
 * @property string  $username
 * @property string  $email
 * @property string  $unconfirmed_email
 * @property string  $password_hash
 * @property string  $auth_key
 * @property string  $registration_ip
 * @property integer $confirmed_at
 * @property integer $blocked_at
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $last_login_at
 * @property integer $flags
 *
 * Defined relations:
 * @property Account[] $accounts
 * @property Profile   $profile
 *
 * Dependencies:
 * @property-read Finder $finder
 * @property-read Module $module
 * @property-read Mailer $mailer
 *
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class User extends \common\models\base\User
{
    public static function usersList() {
        return \yii\helpers\ArrayHelper::map(static::find()
                    ->select(['id', 'username'])
                    ->orderBy('id ASC')
                    ->asArray()
                    ->all(), 'id', 'username');
    }

    public function restArray() {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'confirmed_at' => $this->confirmed_at,
            'created_at' => $this->created_at,
            'last_login_at' => $this->last_login_at,
        ];
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $token = \Yii::$app->jwt->getParser()->parse((string) $token); // Parses from a string
        $signer = new \Lcobucci\JWT\Signer\Hmac\Sha256();

        $data = \Yii::$app->jwt->getValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer(\Yii::$app->params['jwt']['Issuer']);
        $data->setAudience(\Yii::$app->params['jwt']['Audience']);
        $data->setId(\Yii::$app->params['jwt']['Id']);

        $uid = $token->getClaim('uid');

        if ($token->validate($data) && $token->verify($signer, \Yii::$app->jwt->key)) {
            return static::findById($uid);
        }

        return null;
    }

    public static function findById($id) {
        return static::find()
            ->where(['id' => (int)$id])
            ->andWhere(['NOT', ['confirmed_at' => null]])
            ->andWhere(['blocked_at' => null])
            ->limit(1)
            ->one();
    }

    public static function findByUsername($username) {
        return static::find()
            ->where(['username' => $username])
            ->andWhere(['NOT', ['confirmed_at' => null]])
            ->andWhere(['blocked_at' => null])
            ->limit(1)
            ->one();
    }
}