<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $this->params['title'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-article">
    <div class="content-wrap"><!-- content-wrap -->
        <div class="max-width-4 mx-auto p2"><!-- full-width-wrap -->
            <div class="clearfix p2"><!-- clearfix -->

                <h1><?= Html::encode($this->title) ?></h1>

                <div class="articles-wrap">
                    <?php foreach($models as $model) : ?>
                        <div class="clearfix mb2">
                            <?php if ($model->show_image) : ?>
                                <div class="mb1 pr2 md-col md-col-4 item-image-wrap">
                                    <a href="<?= Url::toRoute(['/site/article', 'id' => $model->id]) ?>" class="block">
                                        <amp-img src="<?= $model->image ?>" width="<?= $model->image_width ?>" height="<?= $model->image_height ?>" layout="responsive">
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="mb1 md-col md-col-8 item-content-wrap">
                                <a href="<?= Url::toRoute(['/site/article', 'id' => $model->id]) ?>" class="block item-title-wrap">
                                    <h2><?= $model->title ?></h2>
                                </a>
                                <div class="item-intro-wrap">
                                    <?= $model->intro ?>
                                </div>
                            </div>
                        </div>
                        <hr />
                    <?php endforeach; ?>

                    <?= \yii\widgets\LinkPager::widget(['pagination' => $pagination, 'maxButtonCount' => 5, ]) ?>
                </div>
            </div><!-- clearfix-end -->
        </div><!-- full-width-wrap-end -->
    </div><!-- content-wrap-end -->
</div>
