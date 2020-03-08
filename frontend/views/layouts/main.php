<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-dark navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index'], 'linkOptions' => [], ],
        ['label' => 'About', 'url' => ['/site/about'], 'linkOptions' => [], ],
        ['label' => 'Contact', 'url' => ['/site/contact'], 'linkOptions' => [], ],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/user/registration/register'], 'linkOptions' => [], ];
        $menuItems[] = ['label' => 'Login', 'url' => ['/user/security/login'], 'linkOptions' => [], ];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/user/security/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }

    echo Nav::widget([
        'items' => $menuItems,
        'options' => ['class' =>'nav-pills'], // set this to nav-tab to get tab-styled navigation
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php //echo Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>

        <p class="pull-right"></p>
    </div>
</footer>

<?php if (Yii::$app->request->cookies->getValue('showAcceptCookiesNotify', true)) : ?>
    <div class="fixed-bottom cookie-accept-policy-wrap bg-dark-alpha py-2">
        <div class="container">
            <div class="row h-100">
                <div class="col-md-3 my-auto mb-1 text-center">
                    Мы используем файлы-cookie
                </div>
                <div class="col-md-7 mb-1">
                    Продолжая использовать данный веб-сайт, вы соглашаетесь с тем, что сайт <?= $_SERVER['SERVER_NAME'] ?> может <a href="<?= Url::toRoute(['/site/cookies']) ?>">использовать файлы «cookie»</a> в целях хранения ваших учетных данных, параметров и предпочтений, оптимизации работы веб-сайта.
                </div>
                <div class="col-md-2 my-auto">
                    <a href="<?= Url::toRoute(['/site/accept-cookies-policy']) ?>" class="btn btn-light w-100">Принять</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
