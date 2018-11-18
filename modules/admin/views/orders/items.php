<?php

use yii\helpers\Html; 
use yii\grid\GridView; 
use yii\widgets\Pjax; 

/* @var $this yii\web\View */ 
/* @var $searchModel app\models\search\OrderItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */ 
?>
<?php $this->beginContent('@app/modules/admin/views/orders/_view.php', ['model' => $model]); ?>

    <?php Pjax::begin(); ?>
        
        <?= GridView::widget([ 
            'dataProvider' => $dataProvider, 
            'filterModel' => $searchModel,
            'columns' => [
                'id',
//                'order_id',
//                'product_id',
                'product_name',
                'amount',
                'current_price',
                'price',
                'discount_price',
                'discount_percent',
                //'options',

                ['class' => 'yii\grid\ActionColumn'], 
            ], 
        ]); ?> 
    
    <?php Pjax::end(); ?>

<?php $this->endContent(); ?>
