<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Order */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Orders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="order-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <ul class="nav nav-tabs">
        
        <?php foreach ([
            \app\models\Order::t('Base') => Url::to(['view', 'id' => $model->id]),
            \app\models\Order::t('Items') => Url::to(['view-items', 'id' => $model->id]),
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
