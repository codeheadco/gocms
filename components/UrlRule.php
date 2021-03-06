<?php

namespace codeheadco\gocms\components;

use Yii;
use yii\base\BaseObject;
use yii\web\UrlRuleInterface;

/**
 * Description of UrlRule
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class UrlRule extends BaseObject implements UrlRuleInterface
{
    
    public static $params = [];

    public function createLanguageUrl($language, $manager, $route, $params)
    {
        /* @var $manager UrlManager */
        
        $menuItemI18 = \app\models\MenuItemI18::findOne(['url' => $route]);
        
        if ($menuItemI18) {
            return \app\models\MenuItemI18::findOne([
                'menu_item_id' => $menuItemI18->menu_item_id,
                'language' => $language,
            ])->url;
        }
        
        if (isset($manager->urls[$route])) {
            if (static::parseRouteLanguage($manager->urls[$route], $routeRoute, $routeLanguage)) {
                if (isset($manager->routes["{$routeRoute} {$language}"])) {
                    return $manager->routes["{$routeRoute} {$language}"];
                }
            }
        }
        
        return false;
    }

    public function createUrl($manager, $route, $params)
    {        
        /* @var $manager UrlManager */
        
        $language = \yii\helpers\ArrayHelper::remove($params, 'language');
        
        if ($language) {
            return $this->createLanguageUrl($language, $manager, $route, $params);
        }
        
        $url = \yii\helpers\ArrayHelper::remove($params, 'url');
        
        $menuItemQuery = \app\models\MenuItem::find();
        $menuItemQuery->andWhere(['route' => $route]);
        $menuItemQuery->joinWith('menuItemI18', true, 'INNER JOIN');
        if ($language) {
            $menuItemQuery->andWhere(['menu_item_i18.language' => $language]);
        }
        if ($url) {
            $menuItemQuery->andWhere(['menu_item_i18.url' => $url]);
        }
        $menuItem = $menuItemQuery->one();
        
        if ($menuItem) {
            $menuItemI18 = $menuItem->menuItemI18;
            
            parse_str($menuItemI18->query, $aaa);

            foreach (array_keys($aaa) as $key) {
                unset($params[$key]);
            }
            $queryString = http_build_query($params);

            return $menuItemI18->url . ($queryString ? "?{$queryString}" : '');
        } else {
            $currentLanguage = Yii::$app->language;
            $routeLanguage = "{$route} {$currentLanguage}";
            
            if (isset($manager->routes[$routeLanguage])) {
                $url = $manager->routes[$routeLanguage];
                
                $queryString = http_build_query($params);

                return $url . ($queryString ? "?{$queryString}" : '');
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
