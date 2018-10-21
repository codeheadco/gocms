<?php

namespace codeheadco\gocms\components;

use Yii;
use yii\db\ActiveRecord;
use codeheadco\tools\ReflectionTrait;
use codeheadco\tools\DirectoryInterface;
use yii\helpers\ArrayHelper;

/**
 * Description of BaseActiveRecord
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class BaseActiveRecord extends ActiveRecord
{
    
    use ReflectionTrait;
    
    public static function getTranslationCategory()
    {
        return strtolower(static::classShortName());
    }
    
    public function getImageUrl($attribute, $width = null, $height = null)
    {
        $imageAttribute = $this->getAttribute($attribute);
        
        if ($this instanceof DirectoryInterface) {
            $directoryPath = $this->getDirectoryPath();
            /* @var $directoryPath DirectoryPath */
            return $directoryPath->getWebPath() . "/{$imageAttribute}";
        }
        
        return null;
    }
    
    public function getAttributeLabels($attribute)
    {
        $labels = $this->attributeLabels();
        
        return ArrayHelper::getValue($labels, "{$attribute}_labels", []);
    }
    
}
