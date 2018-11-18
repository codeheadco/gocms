<?php

namespace codeheadco\gocms\editable;

/**
 * Description of HtmlTagTrait
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
trait HtmlTagTrait
{
    
    /**
     *
     * @var type 
     */
    public $title;
    
    /**
     * 
     * @param type $title
     */
    public function title($title)
    {
        $this->title = $title;
        return $this;
    }
    
    /**
     *
     * @var type 
     */
    public $htmlOptions = [];
    
    /**
     * 
     * @param type $htmlOptionName
     * @param type $htmlOptionValue
     * @return $this
     */
    public function htmlOption($htmlOptionName, $htmlOptionValue)
    {
        $this->htmlOptions[$htmlOptionName] = $htmlOptionValue;
        return $this;
    }
    
    /**
     * 
     * @param type $htmlOptions
     * @param type $merge
     * @return $this
     */
    public function htmlOptions($htmlOptions, $merge = false)
    {
        if ($merge) {
            $this->htmlOptions = \yii\helpers\ArrayHelper::merge($this->htmlOptions, $htmlOptions);
        } else {
            $this->htmlOptions = $htmlOptions;
        }
        
        return $this;
    }
    
}
