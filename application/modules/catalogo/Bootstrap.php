<?php

class Catalogo_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initAutoload()
    {
           
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Catalogo_',
            'basePath'  => APPLICATION_PATH . '/modules/catalogo',
            'resourceTypes' => 
            array(                            
                    'entities' => array('path' => '/models/entities', 'namespace' => 'Model_Entity_'),
                    'repositories' => array('path' => '/models/repositories','namespace' => 'Model_Repository_')            
                )));
        
            return $autoloader;
    }
    
    
}
