<?php
/* @var $this \app\components\BaseView */
/* @var $field codeheadco\gocms\editable\fields\Image */
?>
<?= $field->width(200)->render() ?>

<?= codeheadco\tools\modules\files\widgets\FileInput::widget([
    'model' => $field,
    'attribute' => 'content',
    'name' => $field->getAdminInputName('content'),
    'options' => [
        'id' => \yii\helpers\Inflector::slug($field->getAdminInputName('content')),
    ],
]) ?>
