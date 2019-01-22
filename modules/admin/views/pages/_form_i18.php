<?php
/* @var $this \app\components\BaseView */
/* @var $form \app\components\ActiveForm */
/* @var $model app\models\Page */
?>

<?= $form->fieldI18($language, $modelI18, 'name')->textInput() ?>

<?php if ($model->view): ?>

    <?php foreach ($model->getComponents($language) as $component): 
        /* @var $component codeheadco\gocms\editable\Field */ ?>

        <?= $component->renderAdminForm($language) ?>

    <?php endforeach; ?>

<?php else: ?>

    <?= $form->fieldI18($language, $modelI18, 'content')->textarea() ?>

<?php endif; ?>
