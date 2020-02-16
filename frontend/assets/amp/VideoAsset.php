<?php

namespace frontend\assets\amp;

use yii\web\AssetBundle;

/**
 * @author Michael Nordheimer <nordheimerm@gmail.com>
 */
class VideoAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'https://cdn.ampproject.org/v0/amp-video-0.1.js',
    ];
    public $depends = [
        '\frontend\assets\AmpAsset',
    ];
    public $jsOptions = [
        'async' => 'async',
        'custom-element' => 'amp-video',
        'position' => \yii\web\View::POS_HEAD,
    ];
}
