<?php

namespace codeheadco\gocms\modules\admin\controllers;

use app\components\I18ActionFilter;
use Yii;
use app\models\Product;
use app\models\search\ProductsSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ProductsController implements the CRUD actions for Product model.
 */
class ProductsController extends \codeheadco\gocms\modules\admin\components\AdminBaseController
{

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionFileDelete()
    {
        $postData = Yii::$app->request->getBodyParams();
        
        $model = $this->findModel($postData['key']);
        $model->main_image = '';
        
        \yii\helpers\FileHelper::unlink($model->getImagePath('main_image'));
        
        return ['success' => $model->save(false)];
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $postData = Yii::$app->request->post();
        
        $model = new Product();

        if ($model->load($postData) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $language = null)
    {
        $model = $this->findModel($id);
        $modelI18 = $model->getProductI18Model($this->getLanguage());
        
        $modelLoaded = $model->load(Yii::$app->request->post());
        $modelI18Loaded = $modelI18->load(Yii::$app->request->post());
        
        if ($modelLoaded && $modelI18Loaded) {
            $modelValid = $model->validate();
            $modelI18Valid = $modelI18->validate();
            
            if ($modelValid && $modelI18Valid) {
                $model->save(false);
                $modelI18->save(false);
                
                $this->handleFileUpload($model, 'main_image');

                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'modelI18' => $modelI18,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    public function actionUpdateImages($id)
    {
        return $this->render('images', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionUploadImages($id)
    {
        $model = $this->findModel($id);
        
        $productImage = new \app\models\ProductImage();
        $productImage->product_id = $model->id;
        $productImage->save(false);
        
        $this->handleFileUpload($productImage, 'file');
        
        return ['success' => true];
    }
    
    public function actionDeleteImages()
    {
        $imageId = Yii::$app->request->post('key');
        
        $model = \app\models\ProductImage::findOne($imageId);
        $model->delete();
        
        return ['success' => true];
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    public function actionTags()
    {
        $tags = \app\models\Tag::find()->andWhere(['like', 'name', Yii::$app->request->get('term')])->limit(10)->all();
        
        $data = [];
        foreach ($tags as $tag) {
            $data[] = [
                'id' => $tag->id,
                'label' => $tag->name, 
                'value' => $tag->name
            ];
        }
        
        return $data;
    }
}
