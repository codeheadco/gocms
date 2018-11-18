<?php

namespace codeheadco\gocms\editable;

use Yii;

/**
 * Description of Storage
 *
 * @author gabor
 */
class Storage extends \yii\base\Component
{
    
    /**
     *
     * @var Manager
     */
    public $manager;
    
    /**
     * 
     * @param type $create
     * @return \app\models\Page
     */
    protected function findModel($create)
    {
        
        $page = \app\models\Page::find()->where([
            'view' => $this->manager->file
        ])->one();
        
        if ($page) {
            return $page;
        }
        
        if ($create) {
            $page = new \app\models\Page();
            $page->view = $this->manager->file;
            $page->save();
            
            foreach (\app\components\App::getLanguages() as $language) {
                $i18Model = new \app\models\PageI18();
                $i18Model->language = $language;
                $i18Model->page_id = $page->id;
                $i18Model->name = $this->manager->view->title;
                $i18Model->save(false);
            }
            
            return $page;
        }
        
        return null;
    }

//    public function set(Component $component, $value, $language = null)
//    {
//        $page = $this->findModel(true);
//        $pageI18 = $page->getPageI18($language)->one();
//        /* @var $pageI18 \app\models\PageI18 */
//        
//        $content = $pageI18->getArrayAttribute('content');
//        $content[$component->id] = $value;
//        $pageI18->setArrayAttribute('content', $content);
//        $pageI18->save(false);
//    }
    
    public function get(Field $field)
    {
        $page = $this->findModel(false);
        
        if ($page) {
            $language = $this->manager->getLanguage();
            $pageI18 = $page->getI18Model($language);
            /* @var $pageI18 \app\models\PageI18 */
            
            $content = $pageI18->getArrayAttribute('content');
            
            //var_dump($content);die;
            
            \yii\helpers\ArrayHelper::getValue($content, $field->id);
            
            return \yii\helpers\ArrayHelper::getValue($content, $field->id);
        }
        
        return null;
    }
    
    public function getModel($language = null)
    {
        $language = $language ? $language : Yii::$app->language;
        
        $model = $this->findModel(true);
        /* @var $model \app\models\Page */
        $modelI18 = $model->getPageI18($language)->one();
        
        if ($modelI18) {
            return $modelI18;
        }
        
        $modelI18 = $model->getI18Model($language);
        $modelI18->page_id = $model->id;
        $modelI18->save(false);
        
        return $modelI18;
    }

}
