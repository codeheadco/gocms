<?php

namespace codeheadco\gocms\components;

use yii\web\UrlManager as BaseUrlManager;

/**
 * Description of UrlManager
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class UrlManager extends BaseUrlManager
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
