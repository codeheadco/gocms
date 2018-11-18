<?php
/* @var $this \app\components\BaseView */
/* @var $field \codeheadco\gocms\editable\fields\Section */
?>
<div class="panel panel-primary">
    
    <div class="panel-heading">
        <?= yii\bootstrap\Html::activeCheckbox($field, 'visible', [
            'name' => $field->getAdminInputName('visible'),
            'uncheck' => '0',
        ]) ?>
    </div>

    <div class="panel-body">
        
        <?php foreach ($field->getComponents() as $component): 
            /* @var $component codeheadco\gocms\editable\Field */ ?>

            <?= $component->renderAdminForm($language) ?>

        <?php endforeach; ?>
        
    </div>
    
</div>