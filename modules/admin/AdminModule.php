<?php

namespace codeheadco\gocms\modules\admin;

use Yii;
use codeheadco\gocms\components\BaseModule;
use codeheadco\gocms\modules\admin\components\AdminMenu;

/**
 * admin module definition class
 */
class AdminModule extends BaseModule
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'codeheadco\gocms\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        Yii::$app->adminMenu->add(
            'brands', 
            AdminMenu::t('Brands'), 
            \yii\helpers\Url::to('/admin/brands')
        );
        Yii::$app->adminMenu->add(
            'products', 
            AdminMenu::t('Products'), 
            \yii\helpers\Url::to('/admin/products')
        );
        Yii::$app->adminMenu->add(
            'orders', 
            AdminMenu::t('Orders'), 
            \yii\helpers\Url::to('/admin/orders')
        );
        Yii::$app->adminMenu->add(
            'users', 
            AdminMenu::t('Users'), 
            \yii\helpers\Url::to('/user/admin/index')
        );
        Yii::$app->adminMenu->add(
            'menu-items', 
            AdminMenu::t('Menu Items'), 
            \yii\helpers\Url::to('/admin/menu')
        );
    }
    
}
