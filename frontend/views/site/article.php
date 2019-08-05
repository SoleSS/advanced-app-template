<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;

$this->params['gallery'] = $model->hasGallery() ? ['items' => $model->gallery, 'layout' => 'carousel', 'enable_links' => true, 'autoplay' => false] : null;
$this->params['flickrGallery'] = !empty($model->flickrAlbumImages) ? ['items' => $model->flickrAlbumImages, 'layout' => 'carousel', 'enable_links' => true, 'autoplay' => false] : null;

if (isset($model->params['ytvideo']) && $model->params['ytvideo']) {
    \frontend\assets\YoutubeAsset::register($this);
}

if (isset($model->params['iframe']) && $model->params['iframe']) {
    \frontend\assets\IframeAsset::register($this);
}

if (isset($model->params['accordion']) && $model->params['accordion']) {
    \frontend\assets\AccordionAsset::register($this);
}

if (!empty($model->params['flickrAlbumId'])) {
    \frontend\assets\LightboxAsset::register($this);
    \frontend\assets\ListAsset::register($this);
    \frontend\assets\MustacheAsset::register($this);
    \frontend\assets\BindAsset::register($this);
}
?>
<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="article-wrap"><?= $model->full ?></div>
</div>
