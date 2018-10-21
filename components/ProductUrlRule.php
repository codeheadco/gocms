<?php

namespace codeheadco\gocms\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\helpers\ArrayHelper;
use app\models\ProductI18;

/**
 * Description of ProductUrlRule
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class ProductUrlRule implements UrlRuleInterface
{

    public function createUrl($manager, $route, $params)
    {
        $language = ArrayHelper::remove($params, 'language');
        
        if ($language) {
            $productI18 = ProductI18::findOne([
                'url' => $route,
            ]);
            
            if ($productI18) {
                unset($params['id']);
                
                $queryString = http_build_query($params);
                $queryString = $queryString ? "?{$queryString}" : '';
                
                return ProductI18::findOne([
                    'product_id' => $productI18->product_id,
                    'language' => $language,
                ])->url;
            }
        }
        
        if ($productI18 = ArrayHelper::getValue($params, 'productI18')) {
            /* @var $productI18 \app\models\ProductI18 */
            return $productI18->url;
        }
        
        return false;
    }

    public function parseRequest($manager, $request)
    {
        /* @var $manager \yii\web\UrlManager */
        /* @var $request \yii\web\Request */
        $productI18 = ProductI18::find()
                        ->joinWith('product', true, 'INNER JOIN')
                        ->andWhere(['url' => $request->pathInfo])
                        ->one();
        /* @var $productI18 \app\models\ProductI18 */
        
        if ($productI18) {
            Yii::$app->language = $productI18->language;
            
            return ['products/view', ['id' => $productI18->product_id]];
        }
        
        return false;
    }

}
