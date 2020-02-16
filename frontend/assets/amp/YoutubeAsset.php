<?php

namespace frontend\assets\amp;

use yii\web\AssetBundle;

/**
 * @author Michael Nordheimer <nordheimerm@gmail.com>
  */
class YoutubeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'https://cdn.ampproject.org/v0/amp-youtube-0.1.js',
    ];
    public $depends = [
        '\frontend\assets\AmpAsset',
    ];
    public $jsOptions = [
        'async' => 'async',
        'custom-element' => 'amp-youtube',
        'position' => \yii\web\View::POS_HEAD,
    ];
}
