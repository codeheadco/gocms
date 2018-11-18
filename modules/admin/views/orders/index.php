<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\OrderSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Orders');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="order-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute' => 'status',
                'filter' => yii\bootstrap\Html::activeDropDownList(
                                $searchModel, 
                                'status', 
                                app\models\Order::statusLabels(), 
                                [
                                    'class' => 'form-control',
                                    'prompt' => Yii::t('app', 'Choose'),
                                ]
                            ),
                'value' => function (app\models\Order $model) {
                    return yii\helpers\ArrayHelper::getValue(app\models\Order::statusLabels(), $model->status, '?');
                },
            ],
            'paid_at',
            [
                'attribute' => 'payment_method',
                'filter' => yii\bootstrap\Html::activeDropDownList(
                                $searchModel, 
                                'payment_method', 
                                app\models\Order::paymentMethodLabels(), 
                                [
                                    'class' => 'form-control',
                                    'prompt' => Yii::t('app', 'Choose'),
                                ]
                            ),
                'value' => function (app\models\Order $model) {
                    return yii\helpers\ArrayHelper::getValue(app\models\Order::paymentMethodLabels(), $model->payment_method, '?');
                },
            ],
            'first_name',
            'last_name',
            'email:email',
            'phone',
            'created_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
