<?php

namespace app\components;

/**
 * Description of BaseModule
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
abstract class BaseModule extends \yii\base\Module
{
    
    use \codeheadco\tools\ReflectionTrait;

    /**
     *
     * @var type 
     */
    public $defaultRoute = 'index';
    
    public function getBaseUrl()
    {
        return "/{$this->id}";
    }

    public function getUrl()
    {
        return $this->getBaseUrl() . "/index";
    }
    
    public static function setupModules($configDirPath, &$config, $initModules = true)
    {
        if (!isset($config['bootstrap'])) {
            $config['bootstrap'] = [];
        }
        if (!isset($config['modules'])) {
            $config['modules'] = [];
        }
        
        foreach (FileHelper::findDirectories($configDirPath . '/../modules', ['recursive' => false]) as $moduleDirectory) {
            $moduleDirectory_Pi = pathinfo($moduleDirectory);
            
            $moduleClass = "\app\modules\\{$moduleDirectory_Pi['filename']}\Module";

            if ($initModules) {
                $config['bootstrap'][] = $moduleDirectory_Pi['filename'];
            }
            
            $config['modules'][$moduleDirectory_Pi['filename']] = [
                'class' => $moduleClass,
            ];
        }
    }

}
