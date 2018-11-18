<?php

use codeheadco\gocms\modules\admin\components\AdminMenu;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Product;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

?>
<?php $this->beginContent('@app/modules/admin/views/products/_update.php', ['model' => $model]); ?>

    <?php 
        $initialPreview = [];
        $initialPreviewConfig = [];
        
        foreach ($model->productImages as $productImage) {
            /* @var $productImage app\models\ProductImage */
            $initialPreview[] = $productImage->getImageUrl('file');
            $initialPreviewConfig[] = [
                'caption' => "",
                'url' => \yii\helpers\Url::to(['delete-images']),
                'key' => $productImage->id,
            ];
        }
    ?>

    <?= FileInput::widget([
        'name' => yii\bootstrap\Html::getInputName(new app\models\ProductImage(), 'file'),
        'options' => [
            'accept' => 'image/*',
            'multiple' => true,
        ],
        'pluginOptions' => [
            'uploadUrl' => Url::to(['upload-images', 'id' => $model->id]),
//            'deleteUrl' => "/site/file-delete",
//            'uploadExtraData' => [
//                'id' => 20,
//                'cat_id' => 'Nature'
//            ],
//            'maxFileCount' => 10
        ],
        'pluginOptions' => [
            'initialPreview' => $initialPreview,
            'initialPreviewAsData' => true,
            'initialPreviewConfig' => $initialPreviewConfig,
        ],
    ]) ?>

<?php $this->endContent(); ?>
