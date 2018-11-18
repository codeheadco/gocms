<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Order */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="order-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_tax')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_street')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'address_zip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'delivery_first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_address_street')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'delivery_address_zip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'delivery_address_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
