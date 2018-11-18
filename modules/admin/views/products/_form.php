<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $modelI18 app\models\ProductI18 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'brand_id')->dropDownList(
                                            \yii\helpers\ArrayHelper::map(
                                                \app\models\Brand::find()->orderBy('name')->all(), 'id', 'name'
                                            )
                                        ) ?>
    
    <?= $form->field($model, 'model')->textInput(['maxlength' => true]) ?>
    
    <?php 
        $initialPreview = [];
        $initialPreviewConfig = [];
        
        if ($model->main_image) {
            $initialPreview[] = $model->getImageUrl('main_image');
            $initialPreviewConfig[] = [
                'caption' => "",
                'url' => \yii\helpers\Url::to(['file-delete']),
                'key' => $model->id,
            ];
        }
    ?>
    
    <?= $form->field($model, 'main_image')->widget(FileInput::classname(), [
        'options' => [
            'accept' => 'image/*',
        ],
        'pluginOptions' => [
            'initialPreview' => $initialPreview,
            'initialPreviewAsData' => true,
            'initialPreviewConfig' => $initialPreviewConfig,
        ],
    ]) ?>

    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'upc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ean')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jan')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mpn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <?php if (isset($modelI18)): ?>
    
        <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
    
        <div class="panel">
            <div class="panel-body">

                <?= Html::dropDownList('language', $modelI18->language, app\components\App::getLanguages(), ['class' => 'form-control']) ?>

                <?= $form->field($modelI18, 'tags')->textInput(['maxlength' => true]) ?>

                <?= $form->field($modelI18, 'name')->textInput(['maxlength' => true]) ?>

                <?= $form->field($modelI18, 'description')->textInput(['maxlength' => true]) ?>

                <?= $form->field($modelI18, 'meta_title')->textInput(['maxlength' => true]) ?>

                <?= $form->field($modelI18, 'meta_description')->textInput(['maxlength' => true]) ?>

                <?= $form->field($modelI18, 'meta_keyword')->textInput(['maxlength' => true]) ?>

                <?= $form->field($modelI18, 'tag')->textInput(['maxlength' => true]) ?>

            </div>
        </div>
    
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    (function () {
        $("#producti18-tags").tagsInput({
            autocomplete_url: '<?= \yii\helpers\Url::to(['/admin/products/tags']) ?>'
        });

        $('[name="language"]').on('change', function () {
            location.href = location.href + '&language=' + $(this).val();
        });
    })();
</script>