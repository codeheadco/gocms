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
    
    public function handleFileUpload(\yii\db\BaseActiveRecord $model, $attribute, $save = true)
    {
        if (! ($model instanceof \app\components\FileUploadInterface)) {
            throw new \InvalidArgumentException();
        }

        $image = UploadedFile::getInstance($model, $attribute);
        
        if ($image) {
            $fileName = $attribute . '_' . $model->id . '.' . strtolower($image->extension);

            $dirPath = \Yii::getAlias('@webroot') . '/uploads' . $model->getUploadDirName();
            $filePath = $dirPath . '/' . $fileName;
            
            if (!is_dir($dirPath)) {
                \yii\helpers\FileHelper::createDirectory($dirPath);
            }
            
            if ($image->saveAs($filePath)) {
                $model->setAttribute($attribute, $fileName);
                
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
