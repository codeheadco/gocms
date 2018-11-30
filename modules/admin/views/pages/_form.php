<?php

use yii\helpers\Html;
use app\components\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Page */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="page-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>

        <?= $this->render('/_form_tabs_i18', [
            'view' => '/pages/_form_i18',
            'model' => $model,
            'form' => $form,
        ]); ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
