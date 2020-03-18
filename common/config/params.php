<?php
Yii::setAlias('@root', realpath(dirname(__FILE__).'/../../'));
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'frontendFilesRoot' => null,
    'organizationData' => [
        'firmName' => '',
        'firmNameSecondForm' => '',
        'address' => '',
        'postAddress' => '',
    ],
    'jwt' => [
        'Issuer' => 'Issuer',
        'Audience' => 'Audience',
        'Id' => 'Id',
    ],
];
