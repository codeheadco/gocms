<?php

namespace codeheadco\gocms\editable;

/**
 *
 * @author Varga Gábor <gabor87@outlook.com>
 */
interface ContainerInterface
{
    
    public function getManager();

    public function beginField($fieldClass, $id, $config = []);

    public function endField();
    
    public function getComponents($recursive = false);
    
}
