<?php

namespace app\components;

use Yii;

/**
 * Description of ProductUrlRule
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class ProductUrlRule implements \yii\web\UrlRuleInterface
{

    public function createUrl($manager, $route, $params)
    {
        $language = \yii\helpers\ArrayHelper::remove($params, 'language');
        
        if ($language) {
            $productI18 = \app\models\ProductI18::findOne([
                'url' => $route,
            ]);
            
            if ($productI18) {
                unset($params['id']);
                
                $queryString = http_build_query($params);
                $queryString = $queryString ? "?{$queryString}" : '';
                
                return \app\models\ProductI18::findOne([
                    'product_id' => $productI18->product_id,
                    'language' => $language,
                ])->url;
            }
        }
        
        if ($productI18 = \yii\helpers\ArrayHelper::getValue($params, 'productI18')) {
            /* @var $productI18 \app\models\ProductI18 */
            return $productI18->url;
        }
        
        return false;
    }

    public function parseRequest($manager, $request)
    {
        /* @var $manager \yii\web\UrlManager */
        /* @var $request \yii\web\Request */
        $productI18 = \app\models\ProductI18::find()
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
