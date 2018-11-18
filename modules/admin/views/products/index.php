<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Product'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'label' => '',
                'value' => function (app\models\Product $model) {
                    return yii\bootstrap\Html::img($model->getImageUrl('main_image', 30, 30), ['width' => 30, 'height' => 30]);
                },
                'format' => 'raw',
            ],
            [
                'label' => app\models\Product::t('Brand'),
                'filter' => Html::activeDropDownList(
                                $searchModel, 'brand_id', 
                                \yii\helpers\ArrayHelper::map(
                                    \app\models\Brand::find()->orderBy('name')->all(), 'id', 'name'
                                ), 
                                [
                                    'class' => 'form-control',
                                    'prompt' => Yii::t('app', 'Choose'),
                                ]
                        ),
                'value' => function (app\models\Product $model) {
                    return \yii\helpers\ArrayHelper::getValue($model->brand, 'name', '-');
                }
            ],
            'model',
            'sku',
//            'upc',
//            'ean',
            //'jan',
            //'isbn',
            //'mpn',
            'price:currency',
            'quantity',
            'status',
            //'created_at',
            //'created_by',
            //'deleted_at',
            //'deleted_by',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
