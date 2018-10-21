<?php

namespace codeheadco\gocms\components;

/**
 * Description of TranslateTrait
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
trait TranslateTrait
{
    
    public static function t($message, $params = [], $language = null)
    {
        return \Yii::t(static::getTranslationCategory(), $message, $params, $language);
    }
    
    public static function tSource($message, $params = [])
    {
        return static::t($message, $params, TranslateInterface::SOURCE);
    }
    
}
