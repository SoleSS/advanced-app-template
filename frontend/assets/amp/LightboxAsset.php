<?php

namespace frontend\assets\amp;

use yii\web\AssetBundle;

/**
 * @author Michael Nordheimer <nordheimerm@gmail.com>
 */
class LightboxAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];

    /*    public function init() {
        parent::init();
        }*/

    public $js = [
        'https://cdn.ampproject.org/v0/amp-lightbox-0.1.js',
    ];
    public $depends = [
        '\frontend\assets\AmpAsset',
    ];
    public $jsOptions = [
        'async' => 'async',
        'custom-element' => 'amp-lightbox',
        'position' => \yii\web\View::POS_HEAD,
    ];
}
