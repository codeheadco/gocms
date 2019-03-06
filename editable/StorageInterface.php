<?php

namespace codeheadco\gocms\editable;

/**
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
interface StorageInterface
{
    
    public function getPageData(Field $field);
    
    public function getModel($language = null);
    
}
