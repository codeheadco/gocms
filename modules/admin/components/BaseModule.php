<?php

namespace codeheadco\gocms\modules\admin\components;

/**
 * Description of BaseModule
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
class BaseModule extends \app\components\BaseModule implements ModuleAdminInterface
{

    public function getAdminMenuIcon()
    {
        return '';
    }

    public function getAdminMenuLabel()
    {
        return AdminMenu::t(ucfirst($this->id));
    }

    public function getAdminMenuUrl()
    {
        return $this->getBaseUrl() . "/admin";
    }

}
