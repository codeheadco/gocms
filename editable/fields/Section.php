<?php

namespace codeheadco\gocms\editable\fields;

use Yii;
use codeheadco\gocms\editable\Field as BaseField;

/**
 * Description of Section
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class Section extends BaseField implements \codeheadco\gocms\editable\ContainerInterface
{
    
    use \codeheadco\gocms\editable\ContainerTrait;
    
    public $visible = true;
    
    public function getManager()
    {
        return $this->parent->getManager();
    }
    
    public function managedProperties()
    {
        return ['visible'];
    }
    
    public function render()
    {
        $this->loadFromStorage();
        
        if (is_null($this->visible) || $this->visible) {
            return parent::render();
        }
        
        return '';
    }
    
}
