<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Caoxiang <caoxiang@yeah.net>
 * @since 2.0
 */
class JFormAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
    ];
    public $js = [
        'js/jquery.form.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
