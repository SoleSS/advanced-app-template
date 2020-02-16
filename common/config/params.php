<?php
Yii::setAlias('@root', realpath(dirname(__FILE__).'/../../'));
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'frontendFilesRoot' => null,
];
