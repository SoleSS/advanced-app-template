<?php
namespace frontend\assets;

/**
 * @author Michael Nordheimer <nordheimerm@gmail.com>
 */
class AmpAsset extends \yii\web\AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
    ];
    public $js = [
        'https://cdn.ampproject.org/v0.js',
    ];
    public $depends = [
    ];
    public $jsOptions = [
        'async' => 'async',
        'position' => \yii\web\View::POS_HEAD,
    ];
}
