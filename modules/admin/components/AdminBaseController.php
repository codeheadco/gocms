<?php

namespace codeheadco\gocms\modules\admin\components;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * Description of AdminBaseController
 *
 * @author gabor
 */
class AdminBaseController extends Controller
{

    public $layout = '@codeheadco/gocms/modules/admin/views/layouts/main.php';
    
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);
        
        if (is_array($result)) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        }
        
        return $result;
    }
    
    protected function save($model, $view, $fileFields = [])
    {
        $modelShortClass = \codeheadco\tools\Utils::classShortName($model);
        $modelI18ShortClass = "{$modelShortClass}I18";
        
        $postData = Yii::$app->request->post();

        if ($postData) {
            $modelData = ArrayHelper::getValue($postData, $modelShortClass);
            
            if ($modelData) {
                $model->setAttributes($modelData);
            }
            
            if ($model->save()) {
                foreach ($fileFields as $fieldName) {
                    $this->handleFileUpload($model, $fieldName);
                }
                
                $modelI18sData = ArrayHelper::getValue($postData, $modelI18ShortClass);

                if ($modelI18sData) {
                    foreach ($modelI18sData as $language => $modelI18Data) {
                        $categoryI18 = $model->getI18Model($language);
                        /* @var $categoryI18 \app\models\CategoryI18 */
                        $categoryI18->category_id = $model->id;

                        $categoryI18->name = $modelI18Data['name'];
                        $categoryI18->save(false);
                    }
                }
                
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }

        return $this->render($view, [
            'model' => $model,
        ]);
    }
    
    public function handleFileUpload(\yii\db\BaseActiveRecord $model, $attribute, $save = true)
    {
        if (! ($model instanceof \codeheadco\tools\DirectoryInterface)) {
            throw new \InvalidArgumentException();
        }

        $file = UploadedFile::getInstance($model, $attribute);
        
        if ($file) {
            $directoryPath = $model->getDirectoryPath();
            $directoryPath->ensure();
            
            $newFileName = strtolower(time() . '_' . $file->basename . '.' . $file->extension);
            
            if ($file->saveAs($directoryPath->getPath() . "/{$newFileName}")) {
                $model->setAttribute($attribute, $newFileName);
                
                if ($save) {
                    return $model->save(false, [$attribute]);
                }
                
                return true;
            }
        }
        
        return false;
    }

    public function getLanguage()
    {
        $postData = Yii::$app->request->post();
        if (isset($postData['language'])) {
            return $postData['language'];
        }

        $getData = Yii::$app->request->get();
        if (isset($getData['language'])) {
            return $getData['language'];
        }

        return 'hu';
    }
    
}
