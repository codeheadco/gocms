<?php

namespace codeheadco\gocms\editable;

use Yii;
use codeheadco\gocms\editable\fields\Text;
use codeheadco\gocms\editable\fields\Image;
use codeheadco\gocms\editable\fields\Section;
use codeheadco\gocms\editable\fields\Link;

/**
 * Description of ContainerTrait
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
trait ContainerTrait
{
    
    public $components = [];
    
    protected static $stack;
    
    /**
     * 
     * @param type $fieldClass
     * @param type $id
     * @param type $config
     * @return Field|ContainerInterface
     */
    public function beginField($fieldClass, $id, $config = [])
    {
        $manager = $this->getManager();
        /* @var $manager Manager */
        
        if (is_object($fieldClass)) {
            $field = $fieldClass;
        } else {
            $config['id'] = $id;
            $config['manager'] = $manager;
            $config['parent'] = $this;
            
            $field = new $fieldClass($config);
            $manager->getActiveContainer()->components[] = $field;
        }
        
        \yii\di\Instance::ensure($field, Field::class);
        
        if ($field instanceof ContainerInterface) {
            $manager->setActiveContainer($field);
        }
        
        ob_start();
        static::$stack[] = $field;
        
        return $field;
    }
    
    /**
     * 
     */
    public function endField()
    {
        if (!empty(self::$stack)) {
            $field = array_pop(self::$stack);
            $field->content(ob_get_clean());
            
            if ($field instanceof ContainerInterface) {
                $manager = $this->getManager();
                /* @var $manager Manager */
                $manager->popPrevActiveContainer();
            }
            
            echo $field;
        }
    }
    
    /**
     * 
     * @param type $id
     * @param type $config
     * @return Text
     */
    public function text($id, $config = [])
    {
        $manager = $this->getManager();
        /* @var $manager Manager */
        
        $config['id'] = $id;
        $config['manager'] = $this->getManager();
        $config['parent'] = $this;
        
        $text = new Text($config);
        $manager->getActiveContainer()->components[] = $text;
        
        return $text;
    }
    
    /**
     * 
     * @param type $id
     * @param type $config
     * @return Text
     */
    public function beginText($id, $config = [])
    {
        return $this->beginField(Text::class, $id, $config);
    }

    /**
     * 
     */
    public function endText()
    {
        $this->endField();
    }
    
    /**
     * 
     * @param type $id
     * @param type $config
     * @return Image
     */
    public function image($id, $config = [])
    {
        $manager = $this->getManager();
        /* @var $manager Manager */
        
        $config['id'] = $id;
        $config['manager'] = $this->getManager();
        $config['parent'] = $this;
        
        $text = new Image($config);
        $manager->getActiveContainer()->components[] = $text;
        return $text;
    }
    
    /**
     * 
     * @param type $id
     * @param type $config
     * @return Link
     */
    public function link($id, $config = [])
    {
        $manager = $this->getManager();
        /* @var $manager Manager */
        
        $config['id'] = $id;
        $config['manager'] = $this->getManager();
        $config['parent'] = $this;
        
        $text = new Link($config);
        $manager->getActiveContainer()->components[] = $text;
        
        return $text;
    }
    
    /**
     * 
     * @param type $id
     * @param type $config
     * @return Link
     */
    public function beginLink($id, $config = [])
    {
        return $this->beginField(Link::class, $id, $config);
    }
    
    /**
     * 
     */
    public function endLink()
    {
        $this->endField();
    }

    /**
     * 
     * @param type $id
     * @param type $config
     * @return type
     */
    public function beginSection($id, $config = [])
    {
        return $this->beginField(Section::class, $id, $config);
    }
    
    /**
     * 
     */
    public function endSection()
    {
        $this->endField();
    }
    
    /**
     * 
     * @param type $recursive
     * @return Field[]
     */
    public function getComponents($recursive = false)
    {
        if ($recursive) {
            $components = [];
            foreach ($this->components as $component) {
                /* @var $component Field */
                $components[] = $component;
                
                if ($component instanceof ContainerInterface) {
                    foreach ($component->getComponents($recursive) as $subComponent) {
                        $components[] = $subComponent;
                    }
                }
            }
            
            return $components;
        }
        
        return $this->components;
    }
    
}
