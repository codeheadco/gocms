<?php 

use yii\helpers\Url;

/* @var $this yii\web\View */
?>
<?php $this->beginContent('@codeheadco/gocms/modules/admin/views/layouts/base.php'); ?>

    <header class="main-header">
        <!-- Logo -->
        <a href="#" class="logo">
            <?php 
                $appName = Yii::$app->name; 
                $appName0 = str_split($appName); 
                $appName1 = explode(' ', $appName); 
            ?>
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b><?= array_shift($appName0) ?></b><?= join('', $appName0) ?></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b><?= $appName1[0] ?></b><?= isset($appName1[1]) ? $appName1[1] : '' ?></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?= Url::base()?>/dist/img/user.png" class="user-image" alt="User Image">
                            <span class="hidden-xs">
                                <?= 'Valaki' ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="<?= Url::base()?>/dist/img/user.png" class="img-circle" alt="User Image">

                                <p>
                                    <?= 'Valaki' ?>
                                </p>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?= Url::to(['/user']) ?>" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?= yii\helpers\Url::to(['login/logout']) ?>" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header"><?= codeheadco\gocms\modules\admin\components\AdminMenu::t('Main Menu') ?></li>

                <?php $userModel = Yii::$app->user->identity;

                foreach (Yii::$app->adminMenu->get() as $menuPoint): 
                    if (!empty($menuPoint['visible'])) {
                        continue;
                    } 
                    
                    $icon = \yii\helpers\ArrayHelper::remove($menuPoint['options'], 'icon'); 
                    
                    if (Yii::$app->request->pathInfo == ltrim($menuPoint['url'], '/')) {
                        yii\bootstrap\Html::addCssClass($menuPoint['options'], 'active');
                    } ?>

                    <?= yii\bootstrap\Html::beginTag('li', $menuPoint['options']) ?>
                
                        <a href="<?= Url::toRoute([$menuPoint['url']]) ?>">
                            
                            <?php if ($icon): ?>
                            
                                <i class="<?= $icon ?>"></i>
                            
                            <?php endif ?>
                            
                            <span><?= $menuPoint['label'] ?></span>
                            
                        </a>
                
                    <?= yii\bootstrap\Html::endTag('li') ?>

                <?php endforeach; ?>

            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        
        <?= $content ?>
        
    </div>

<?php $this->endContent(); ?>