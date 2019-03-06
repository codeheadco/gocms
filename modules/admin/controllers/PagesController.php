<?php

namespace codeheadco\gocms\modules\admin\controllers;

use Yii;
use app\models\Page;
use app\models\search\PageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * PagesController implements the CRUD actions for Page model.
 */
class PagesController extends \codeheadco\gocms\modules\admin\components\AdminBaseController
{

    /**
     * Lists all Page models.
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->pagesManager->update();
        
        $searchModel = new PageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Updates an existing Page model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        /* @var $model Page */
        
        $postData = Yii::$app->request->post();

        if ($model->load($postData) && $model->save()) {
            $modelI18sData = \yii\helpers\ArrayHelper::getValue($postData, 'PageI18');

            foreach ($modelI18sData as $language => $pageI18Data) {
                $pageI18 = $model->getI18Model($language);
                /* @var $pageI18 \app\models\PageI18 */
                $pageI18->page_id = $model->id;

                $pageI18->name = $pageI18Data['name'];

                if ($model->view) {
                    $pageI18->setArrayAttribute('content', $pageI18Data['content']);
                } else {
                    $pageI18->content = $pageI18Data['content'];
                }

                $pageI18->save(false);
            }

            return $this->redirect(['update', 'id' => $model->id]);
        }

        $pagesManager = Yii::$app->pagesManager;
        /* @var $pagesManager \codeheadco\gocms\editable\Manager */
        $pagesManager->update();

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Page model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Page the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Page::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
