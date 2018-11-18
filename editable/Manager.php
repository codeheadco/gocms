<?php

namespace codeheadco\gocms\editable;

use Yii;

/**
 * Description of Manager
 *
 * @author gabor
 */
class Manager extends \yii\base\Behavior implements ContainerInterface
{
    
    use ContainerTrait;
    
    /**
     *
     * @var type 
     */
    public $view;
    
    /**
     *
     * @var type 
     */
    public $file;
    
    /**
     *
     * @var type 
     */
    public $viewsPath = '@app/views/pages';
    
    public function init()
    {
        parent::init();
        
        $this->activeContainer = $this;
    }
    
    protected $activeContainer;
    
    protected $prevContainers;
    
    public function setActiveContainer(ContainerInterface $container)
    {
        $this->prevContainers[] = $this->activeContainer;
        $this->activeContainer = $container;
        return $this;
    }
    
    public function getActiveContainer()
    {
        return $this->activeContainer;
    }
    
    public function popPrevActiveContainer()
    {
        $this->activeContainer = array_pop($this->prevContainers);
    }

    /**
     *
     * @var type 
     */
    protected $language;

    /**
     * 
     * @return $this
     */
    public function resetLanguage()
    {
        $this->setLanguage(null);
        return $this;
    }
    
    /**
     * 
     * @param type $language
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        $this->setupView();
        return $this;
    }
    
    /**
     * 
     * @return type
     */
    public function getLanguage()
    {
        return $this->language ? $this->language : Yii::$app->language;
    }

    /**
     * 
     * @param \yii\web\View $view
     */
    public function attachView(\yii\web\View $view)
    {
        $this->view = $view;
        
        $viewFile = $this->view->getViewFile();
        $this->file = substr($viewFile, strlen(Yii::getAlias('@app')) + 1, strlen($viewFile));
        
        $view->attachBehavior('editable', $this);
        
        $this->setupView();
    }
    
    /**
     * 
     */
    public function setupView()
    {
        if ($this->view) {
            $model = $this->storage()->getModel();
            
            $this->view->title = $model ? $model->name : '';
        }
    }
    
    /**
     * 
     * @return $this
     */
    public function editable()
    {
        return $this;
    }
    
    /**
     * @inheritdoc
     */
    public function getManager()
    {
        return $this;
    }
    
    /**
     *
     * @var type 
     */
    protected $_storage;
    
    /**
     * 
     * @return Storage
     */
    public function storage()
    {
        return $this->_storage = new Storage(['manager' => $this]);
    }
    
    /**
     * 
     * @param type $file
     */
    public function loadComponents($file)
    {
        $this->components = [];
        Yii::$app->view->renderFile($file);
    }
    
    public function update()
    {
        $managedViewFiles = \yii\helpers\FileHelper::findFiles(Yii::getAlias(Yii::$app->pagesManager->viewsPath));
        
        $view = Yii::$app->view;
        /* @var $view \app\components\BaseView */
        
        foreach ($managedViewFiles as $managedViewFile) {
            $managedViewFile_Pi = pathinfo($managedViewFile);
            
            if (0 === strpos($managedViewFile_Pi['filename'], '_')) {
                continue;
            }
            
            $view->renderFile($managedViewFile);
            
            $editable = $view->getBehavior('editable');
            /* @var $editable \codeheadco\gocms\editable\Manager */
                    
            if ($editable) {
                $components = $editable->getComponents(true);
                /* @var $components Field[] */
                
                $model = $editable->storage()->getModel('hu');
                /* @var $model \app\models\PageI18 */
                                
                $componentsData = $model->getArrayAttribute('content');
                
                foreach ($components as $component) {
                    $componentsData[$component->id] = \yii\helpers\ArrayHelper::merge(
                                                          $component->getManagedProperties(), 
                                                          \yii\helpers\ArrayHelper::getValue($componentsData, $component->id, [])
                                                      ); 
                }
                
                $model->setArrayAttribute('content', $componentsData);
                $model->save(false);
                
                $view->detachBehavior('editable');
            }
        }
    }

}
