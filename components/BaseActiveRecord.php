<?php

namespace codeheadco\gocms\components;

use Yii;
use yii\db\ActiveRecord;

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
//    
//    public function getImagePath($attribute)
//    {
//        $imageName = $this->getAttribute($attribute);
//        return \Yii::getAlias('@webroot') . "/uploads" . $this->getUploadDirName() . "/{$imageName}";
//    }
    
    public function getAttributeLabels($attribute)
    {
        $labels = $this->attributeLabels();
        
        return \yii\helpers\ArrayHelper::getValue($labels, "{$attribute}_labels", []);
    }
    
    public static function processTemplateWith($model, $template)
    {
        $data = $template;
        
        if ($model) {
            if (preg_match_all('#{(.+?)}#', $template, $matches)) {
                foreach ($matches[1] as $toReplace) {
                    $data = trim(str_replace("{{$toReplace}}", \yii\helpers\ArrayHelper::getValue($model, $toReplace, ''), $data));
                }
            }
        }
        
        return $data;
    }
    
}
