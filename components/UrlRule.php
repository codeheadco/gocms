<?php

namespace codeheadco\gocms\components;

use Yii;

/**
 * Description of UrlRule
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class UrlRule extends \yii\base\BaseObject implements \yii\web\UrlRuleInterface
{
    
    public static $params = [];

    public function createUrl($manager, $route, $params)
    {
        /* @var $manager UrlManager */
        
        $language = \yii\helpers\ArrayHelper::remove($params, 'language');
        
        $menuItemI18 = \app\models\MenuItemI18::findOne([
            'url' => $route,
        ]);

        if ($menuItemI18) {
            parse_str($menuItemI18->query, $aaa);

            foreach (array_keys($aaa) as $key) {
                unset($params[$key]);
            }

            $queryString = http_build_query($params);
            $queryString = $queryString ? "?{$queryString}" : '';

            return \app\models\MenuItemI18::findOne([
                'menu_item_id' => $menuItemI18->menu_item_id,
                'language' => $language ? $language : Yii::$app->language,
            ])->url
            . $queryString;
        } else {
            if (isset($manager->urls[$route])) {
                $routeLanguage = $manager->urls[$route];

                if (static::parseRouteLanguage($routeLanguage, $routeByUrl, $languageByUrl)) {
                    $queryString = http_build_query($params);
                    $queryString = $queryString ? "?{$queryString}" : '';

                    if (isset($manager->routes["{$routeByUrl} {$language}"])) {
                        return $manager->routes["{$routeByUrl} {$language}"]
                        . $queryString;
                    }
                }
            }
        }
        
        return false;
    }

    public function parseRequest($manager, $request)
    {
        /* @var $manager UrlManager */
        /* @var $request \yii\web\Request */
        
        $pathInfo = $request->pathInfo;
        
        if (preg_match('#^en#', $pathInfo, $matches)) {
            Yii::$app->language = 'en';
        }
        
        static::$params['pathInfo'] = $pathInfo;
        
        $menuItemI18s = \app\models\MenuItemI18::findAll([
            'url' => $pathInfo,
        ]);
        
        if ($menuItemI18s) {
            if (1 < count($menuItemI18s)) {
                foreach ($menuItemI18s as $menuItemI18) {
                    /* @var $menuItemI18 \app\models\MenuItemI18 */
                    if (Yii::$app->language == $menuItemI18->language) {
                        break;
                    }
                }
            } else {
                $menuItemI18 = $menuItemI18s[0];
            }
            
            Yii::$app->language = $menuItemI18->language;
        
            $menuItem = \app\models\MenuItem::findOne($menuItemI18->menu_item_id);
            static::$params['menuItem'] = $menuItem;
            static::$params['menuItemI18'] = $menuItemI18;
            static::$params['query'] = $menuItemI18->query;
            parse_str($menuItemI18->query, $aaa);
//            static::$params = array_merge(static::$params, (array) $aaa);
            
            return [$menuItem->route, $aaa];
        }
        
        if (isset($manager->urls[$pathInfo])) {
            if (static::parseRouteLanguage($manager->urls[$pathInfo], $route, $language)) {
                Yii::$app->language = $language;
                
                return [$route, []];
            }
        }
        
        return false;
    }
    
    public static function parseRouteLanguage($routeLanguage, &$route, &$language)
    {
        if (preg_match('#(?<route>\S+)\s(?<language>\S+)#', $routeLanguage, $matches)) {
            $route = $matches['route'];
            $language = $matches['language'];
            
            return true;
        }
        
        return false;
    }

}
