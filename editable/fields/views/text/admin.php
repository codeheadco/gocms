<?php
/* @var $this \app\components\BaseView */
?>
<div class="panel panel-default">
    
    <div class="panel-body">
        
        <?= yii\bootstrap\Html::activeTextInput($field, 'content', [
            'class' => 'form-control',
            'name' => $field->getAdminInputName('content'),
        ]) ?>
        
    </div>
    
</div>