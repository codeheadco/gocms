<?php

namespace codeheadco\gocms\modules\admin\components;

/**
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
interface ModuleAdminInterface
{
    
    public function getAdminMenuLabel();
    
    public function getAdminMenuIcon();
    
    public function getAdminMenuUrl();
    
}
