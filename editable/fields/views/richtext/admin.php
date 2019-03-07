<?php
/* @var $this \app\components\BaseView */
?>

<div class="panel panel-default">
    
    <div class="panel-body">
        
        <?= \dosamigos\ckeditor\CKEditor::widget([
            'model' => $field,
            'attribute' => 'content',
            'name' => $field->getAdminInputName('content'),
            'options' => [
                'name' => $field->getAdminInputName('content'),
            ]
        ]) ?>
        
    </div>
    
</div>
