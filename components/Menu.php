<?php

namespace codeheadco\gocms\components;

/**
 * Description of Menu
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class Menu implements \app\components\TranslateInterface
{
    
    use \app\components\TranslateTrait;
    
    public static function getTranslationCategory()
    {
        return 'menu';
    }
    
}
