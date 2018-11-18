<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm; 

/* @var $this yii\web\View */
/* @var $model app\models\Order */
?>
<?php $this->beginContent('@codeheadco/gocms/modules/admin/views/orders/_view.php', ['model' => $model]); ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'payment_method',
            'first_name',
            'last_name',
            'email:email',
            'phone',
            'company_name',
            'company_tax',
            [
                'label' => 'Szállítási információk',
                'value' => '',
                'rowOptions' => [
                    'style' => 'background:#ff0'
                ],
            ],
            'address_street:ntext',
            'address_zip',
            'address_country',
            'comment:ntext',
            'delivery_first_name',
            'delivery_last_name',
            'delivery_phone',
            'delivery_address_street:ntext',
            'delivery_address_zip',
            'delivery_address_country',
            'created_at',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>
    
        <h1>Műveletek</h1>
        
        <div class="row">
            
            <div class="col-sm-6">
                <?= $form->field($model, 'status')->dropDownList(
                    app\models\Order::statusLabels(), 
                    [
                        'prompt' => Yii::t('app', 'Choose'),
                        'class' => 'form-control',
                    ]
                ) ?>
            </div>
            <div class="col-sm-6">
                <?= $form->field($model, 'payment_method')->dropDownList(
                    app\models\Order::paymentMethodLabels(), 
                    [
                        'prompt' => Yii::t('app', 'Choose'),
                        'class' => 'form-control',
                        'disabled' => 'disabled',
                    ]
                ) ?>
            </div>
            
        </div>
        <div class="row">
            
            <div class="col-sm-6">
                <?= yii\bootstrap\Html::button(app\models\Order::t('Set Paid'), ['id' => 'btn-set-paid']) ?>
            </div>
            <div class="col-sm-6">
                
            </div>
            
        </div>
        
        <br>
        <br>

        <div class="form-group"> 
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?> 
        </div>

    <?php ActiveForm::end(); ?>
        
    <script type="text/javascript">
        (function () {
            $('#btn-set-paid').on('click', function () {
                alert(123)
            });
        })();
    </script>

<?php $this->endContent(); ?>
