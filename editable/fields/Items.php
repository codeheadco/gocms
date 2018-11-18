<?php

namespace codeheadco\gocms\editable\fields;

/**
 * Description of Items
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class Items extends Section
{

    public $items;
    
    public function managedProperties()
    {
        $managedProperties = parent::managedProperties();
        $managedProperties[] = 'items';
        
        return $managedProperties;
    }
    
    

}
