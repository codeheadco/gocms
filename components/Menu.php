<?php

namespace codeheadco\gocms\components;

use Yii;
use codeheadco\tools\TranslateInterface;
use codeheadco\tools\TranslateTrait;

/**
 * Description of Menu
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class Menu implements TranslateInterface
{
    
    use TranslateTrait;
    
    public static function getTranslationCategory()
    {
        return 'menu';
    }
    
}
