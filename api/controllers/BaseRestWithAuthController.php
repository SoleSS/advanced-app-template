<?php
namespace api\controllers;


class BaseRestWithAuthController extends BaseRestController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator']['class'] = \sizeg\jwt\JwtHttpBearerAuth::class;
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;
    }
}
