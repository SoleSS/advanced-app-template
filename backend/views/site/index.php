<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = 'Управление сайтом';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Панель управления сайтом</h1>

        <p class="lead text-left">В горизонтальном меню размещены все разделы сайта:</p>
        <ul class="list-unstyled text-left">
            <li><span class="glyphicon glyphicon-hdd"></span> Файловый менеджер</li>
            <li><span class="glyphicon glyphicon-user"></span> Управление пользователями</li>
            <li><span class="glyphicon glyphicon-inbox"></span> Менеджер категорий</li>
            <li><span class="glyphicon glyphicon-pencil"></span> Менеджер материалов</li>
            <li><span class="glyphicon glyphicon-tags"></span> Управление тегами</li>
            <li><span class="glyphicon glyphicon-ok"></span> Менеджер опросов</li>
            <li><span class="glyphicon glyphicon-education"></span> Управление тестами</li>
            <li><span class="glyphicon glyphicon-question-sign"></span> Менеджер тестовых вопросов</li>
        </ul>

    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2><span class="glyphicon glyphicon-pencil"></span> Менеджер материалов</h2>

                <p>Система управления контентон с поддержкой технологии Google AMP</p>

                <p><a class="btn btn-default" href="<?= Url::toRoute(['/cms/cms-article/index']) ?>">Перейти &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
