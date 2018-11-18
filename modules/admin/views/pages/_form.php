<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
    
    <?php foreach ($model->getWidgets() as $one): 
        $widgetInstance = $one[0]::begin($one[1]);
        $one[0]::end(); ?>
    
        <div class="panel">
            
            <?= $widgetInstance->admin($model) ?>
            
        </div>
    
    <?php endforeach; ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
