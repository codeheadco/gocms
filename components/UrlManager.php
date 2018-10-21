<?php

namespace codeheadco\gocms\components;

/**
 * Description of UrlManager
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class UrlManager extends \yii\web\UrlManager
{
    
    public $urls = [];
    
    public $routes = [];
    
    public function init()
    {
        parent::init();
        
        foreach ($this->urls as $url => $routeLanguage) {
            $this->routes[$routeLanguage] = $url;
        }
    }
    
}
