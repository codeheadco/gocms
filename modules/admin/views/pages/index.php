<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

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
                                $searchModel, 'status', 
                                app\models\Page::getStatusLabels(),
                                ['class' => 'form-control']
                            ),
            ],
//            'created_at',
            //'created_by',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $index) {
                        if ($model->view) {
                            return;
                        }
                        
                        return yii\bootstrap\Html::a(
                                   yii\bootstrap\Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']), 
                                   $url
                               );
                    }
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
