<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace codeheadco\gocms\modules\admin\assets;
use yii\web\View;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $sourcePath = '@codeheadco/gocms/modules/admin/assets/main/src/';
    public $css = [
        'css/font-awesome/font-awesome.css',
        'css/Ionicons/css/ionicons.min.css',
        'css/adminlte/css/AdminLTE.min.css',
        'css/adminlte/css/skins/_all-skins.min.css',
        'css/morris/morris.css',
        'css/iCheck/all.css',
        'css/admin.css',
        'jquery-ui-1.12.1/jquery-ui.min.css',
        'jQuery-Tags-Input-master/dist/jquery.tagsinput.min.css',

    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $js = [
        'js/adminlte/js/adminlte.min.js',
        'js/morris/morris.min.js',
        'js/raphael/raphael.min.js',
        'js/iCheck/icheck.min.js',
        'js/admin.js',
        'jquery-ui-1.12.1/jquery-ui.min.js',
        'jQuery-Tags-Input-master/dist/jquery.tagsinput.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];

//    public function init()
//    {
//        $this->jsOptions['position'] = View::POS_BEGIN;
//        parent::init();
//    }
}