<?php
/* @var $this \app\components\BaseView */
/* @var $field codeheadco\gocms\editable\fields\Link */
?>
<div class="panel panel-default">
    
    <div class="panel-body">
        
        Link
        
        <div>
            <?= yii\bootstrap\Html::activeTextInput($field, 'url', [
                'class' => 'form-control',
                'name' => $field->getAdminInputName('content'),
            ]) ?>
        </div>
        
        <div>
            <?php foreach ($field->getComponents() as $component): 
                /* @var $component codeheadco\gocms\editable\Field */ ?>

                <?= $component->renderAdminForm($language) ?>

            <?php endforeach; ?>
        </div>
        
    </div>
    
</div>