<?php
/* @var $this \app\components\BaseView */
?>
<?php $tabs = \codeheadco\gocms\widgets\Tabs::begin(); ?>

    <?php foreach (app\components\App::getLanguageLabels() as $language => $languageName): 
        $modelI18 = $model->getI18Model($language); 
        /* @var $modelI18 \app\models\PageI18 */ 
        
        $renderParams = [
            'model' => $model,
            'modelI18' => $modelI18,
            'form' => $form,
            'language' => $language,
            'languageName' => $languageName,
        ]; ?>

        <?php $tabs->beginTab($languageName) ?>

            <?= $this->render($view, $renderParams) ?>

        <?php $tabs->endTab() ?>

    <?php endforeach; ?>

<?php \codeheadco\gocms\widgets\Tabs::end(); ?>