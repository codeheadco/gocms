<?php

namespace codeheadco\gocms\editable\fields;

use codeheadco\gocms\editable\Field as BaseField;
use codeheadco\gocms\editable\HtmlTagTrait;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * Description of Image
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class Image extends BaseField
{
    
    use HtmlTagTrait;
    
    /**
     *
     * @var type 
     */
    public $alt;
    
    /**
     *
     * @var type 
     */
    public $blank;
    
    /**
     *
     * @var type
     */
    public $width;
    
    /**
     *
     * @var type 
     */
    public $height;

    /**
     * @inheritdoc
     */
    public function managedProperties()
    {
        return ['content', 'title', 'alt', 'blank'];
    }

    /**
     * 
     * @param type $src
     * @return $this
     */
    public function src($src)
    {
        return parent::content($src);
    }
    
    /**
     * 
     * @param type $blank
     */
    public function blank($blank)
    {
        $this->blank = $blank;
        return $this;
    }
    
    /**
     * 
     * @param type $width
     */
    public function width($width)
    {
        $this->width = $width;
        return $this;
    }
    
    /**
     * 
     * @param type $height
     */
    public function height($height)
    {
        $this->height = $height;
        return $this;
    }
    
    /**
     * 
     * @param type $width
     * @param type $height
     */
    public function dimensions($width = null, $height = null)
    {
        $this->width = $width;
        $this->height = $height;
        return $this;
    }
    
    /**
     * @inheritdoc
     */
    public function render()
    {
        $this->loadFromStorage();
        
        return Html::img($this->content, ArrayHelper::merge(
                [
                    'title' => $this->title,
                    'alt' => $this->alt,
                    'width' => $this->width,
                    'height' => $this->height,
                ], 
                ((array) $this->htmlOptions)
            )
        );
    }

}
