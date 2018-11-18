<?php

use codeheadco\gocms\modules\admin\components\AdminMenu;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Product;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = Product::t('Update Product:' . ' ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => AdminMenu::t('Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="nav nav-tabs">
        
        <?php foreach ([
            Product::t('Base') => Url::to(['update', 'id' => $model->id]),
            Product::t('Images') => Url::to(['update-images', 'id' => $model->id]),
        ] as $label => $url): ?>
        
            <li class="<?= false === strpos(Url::current(), $url) ? '' : 'active' ?>">
                <a href="<?= $url ?>"><?= $label ?></a>
            </li>
        
        <?php endforeach; ?>
            
    </ul>

    <div class="tab-content">
        
        <?= $content ?>
        
    </div>

</div>
