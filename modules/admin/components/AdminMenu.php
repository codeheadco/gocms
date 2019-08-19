<?php

namespace codeheadco\gocms\modules\admin\components;

/**
 * Description of AdminMenu
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class AdminMenu
{

    protected $menu;

    public function add($id, $label, $url, $options = [])
    {
        $this->menu[$id] = [
            'label' => $label,
            'url' => $url,
            'options' => $options
        ];
    }
    
    public function addModule(ModuleAdminInterface $module, $options = [])
    {
        if (!isset($options['icon'])) {
            $options['icon'] = $module->getAdminMenuIcon();
        }
        
        $this->add($module->id, $module->getAdminMenuLabel(), $module->getAdminMenuUrl(), $options);
    }
    
    public function get()
    {
        return $this->menu;
    }

}
