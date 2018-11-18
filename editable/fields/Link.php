<?php

namespace codeheadco\gocms\editable\fields;

use codeheadco\gocms\editable\Field as BaseField;
use codeheadco\gocms\editable\ContainerInterface;
use codeheadco\gocms\editable\ContainerTrait;
use codeheadco\gocms\editable\HtmlTagTrait;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Description of Link
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class Link extends BaseField implements ContainerInterface
{
    
    use ContainerTrait;
    use HtmlTagTrait;
    
    public $url;
    
    public $blank = false;
    
    public function getManager()
    {
        return $this->parent->getManager();
    }
    
    public function managedProperties()
    {
        return ['content', 'url', 'blank'];
    }
    
    public function url($url)
    {
        $this->url = $url;
        return $this;
    }
    
    public function blank($blank)
    {
        $this->blank = $blank;
        return $this;
    }

    public function render()
    {
        $this->loadFromStorage();
        
        return Html::a(parent::render(), $this->url, ArrayHelper::merge(
                [
                    '_target' => $this->blank ? '_blank' : null
                ], 
                ((array) $this->htmlOptions)
            )
        );
    }
    
}
