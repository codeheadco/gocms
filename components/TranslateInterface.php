<?php

namespace codeheadco\gocms\components;

/**
 * Description of Translatable
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
interface TranslateInterface {
    
    const SOURCE = 'en';
    
    public static function getTranslationCategory();
    
}
