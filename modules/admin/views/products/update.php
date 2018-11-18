<?php

use codeheadco\gocms\modules\admin\components\AdminMenu;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Product;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

?>
<?php $this->beginContent('@app/modules/admin/views/products/_update.php', ['model' => $model]); ?>

    <?= $this->render('_form', [
        'model' => $model,
        'modelI18' => $modelI18,
    ]) ?>

<?php $this->endContent(); ?>
