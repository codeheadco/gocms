<?php
/* @var $this \app\components\BaseView */
/* @var $field codeheadco\gocms\editable\fields\Image */
?>
<?= $field->render() ?>
<?= yii\bootstrap\Html::activeTextInput($field, 'content', [
    'class' => 'form-control',
    'name' => $field->getAdminInputName('content'),
]) ?>