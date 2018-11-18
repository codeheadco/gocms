<?php 
use yii\web\View;
use yii\helpers\Url;
use codeheadco\gocms\modules\admin\assets\AppAsset;

$asset = AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?= Yii::$app->name ?> | Admin</title>
        <?php $this->head() ?>
        <base href="/">
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
            
        <?= yii\helpers\Html::csrfMetaTags() ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        
        <?php $this->beginBody() ?>
        
            <?= $content ?>
        
        <?php $this->endBody() ?>
        
    </body>
</html>
<?php $this->endPage() ?>