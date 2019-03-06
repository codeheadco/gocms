<?php

namespace codeheadco\gocms\editable;

use Yii;

/**
 * Description of Field
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
abstract class Field extends \yii\base\Model
{
    
    use \codeheadco\tools\ReflectionTrait;
    
    /**
     *
     * @var Manager
     */
    public $manager;
    
    /**
     *
     * @var ContainerInterface
     */
    public $parent;
    
    /**
     *
     * @var type 
     */
    public $id;
    
    /**
     *
     * @var type 
     */
    public $content;

    /**
     * 
     * @return type
     */
    public function managedProperties()
    {
        return ['content'];
    }
    
    /**
     * 
     * @param type $content
     */
    public function content($content)
    {
        $this->content = $content;
        return $this;
    }
    
    /**
     * 
     * @return Storage
     */
    protected function getStorage()
    {
        return $this->manager->storage();
    }
    
    /**
     * 
     */
    protected function loadFromStorage()
    {
        $stored = $this->getStorage()->getPageData($this);
        
        if ($stored) {
            foreach ($stored as $propertyName => $value) {
                if ($this->canSetProperty($propertyName)) {
                    $this->$propertyName = $value;
                }
            }
        }
    }
    
    /**
     * 
     * @return type
     */
    public function getManagedProperties()
    {
        $properties = [];
        foreach ($this->managedProperties() as $property) {
            $properties[$property] = $this->$property;
        }
        
        return $properties;
    }
    
    /**
     * 
     * @return type
     */
    public function render()
    {
        $this->loadFromStorage();
        
        return $this->content;
    }
    
    /**
     * 
     * @return string
     */
    public function __toString()
    {
        try {
            return (string) $this->render();
        } catch (\Exception $e) {
            \yii\base\ErrorHandler::convertExceptionToError($e);
        }
        
        return '';
    }
    
    public function getViewPath()
    {
        return __DIR__ . '/fields/views/' . strtolower(static::classShortName());
    }
    
    public function getAdminInputName($property)
    {
        $language = $this->manager->getLanguage();
        $saveModel = $this->manager->storage()->getModel();
        
        if ($saveModel->hasAttribute('language')) {
            return \codeheadco\tools\Utils::classShortName($saveModel)
                    . "[{$language}][content][{$this->id}][{$property}]";
        }
        
        return \codeheadco\tools\Utils::classShortName($saveModel)
                . "[content][{$this->id}][{$property}]";
    }
    
    /**
     * 
     * @param type $language
     * @return type
     */
    public function renderAdminForm($language)
    {
        $viewFile = $this->getViewPath() . '/admin.php';
        
        return Yii::$app->view->renderFile($viewFile, [
            'field' => $this,
            'language' => $language,
        ]);
    }
    
}
