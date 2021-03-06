<?php
Doctrine\DBAL\Types\Type::overrideType('datetime', 'ProyectoZF\DBAL\Types\DateTimeType');

use Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
    Doctrine\DBAL\DriverManager,
    Doctrine\Common\Cache\ApcCache;

use Zend_Controller_Action_HelperBroker as HelperBroker;

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
    protected function _initConfig() {
        
        $config = new Zend_Config_Ini('config.ini', 'default');
        Zend_Registry::set("config", $config);
        return $config;
        
    }

    protected function _initEnvironment() {
        
        if ($this->getEnvironment() == "development") {
            error_reporting(E_ALL | E_STRICT);
            ini_set("display_errors", true);
        }

        $timeZone = (string) Zend_Registry::get('config')->parametros->timezone;
        
        if ( empty($timeZone ) ) {
            $timeZone = "America/Santiago";
        }
        
        date_default_timezone_set($timeZone);
        
        return null;

    }
    
    protected function _initDoctrine()
    {
       
        $config = new Configuration();
        $cache = new ApcCache();
        $config->setMetadataCacheImpl($cache);
        $driver = $config->newDefaultAnnotationDriver();
        $config->setMetadataDriverImpl($driver);        
        $config->setQueryCacheImpl($cache);
       
        //$config->setProxyDir(APPLICATION_PATH . "/../library" . DIRECTORY_SEPARATOR .'Proxies');
        $config->setProxyDir(APPLICATION_PATH . "/../library/ProyectoZF/Application/Module/Model/Proxy");
        $config->setProxyNamespace('Proxies');
        
        $connPDO = array();
        $this->bootstrap('db');
        $connPDO['pdo'] = $this->getResource('db')->getConnection();
        $conn = DriverManager::getConnection($connPDO, $config);
        $em = EntityManager::create($conn, $config);
        Zend_Registry::set('em', $em);
        return $em;
    }
    
    public function _initActionHelperEm()
    {
        $this->bootstrap('doctrine');
        $em = $this->getResource('doctrine');

        HelperBroker::addHelper(new ProyectoZF_Controller_Action_Helper_Em($em));
    }   
 
    protected function _initTranslate()
    {
        $locale = new Zend_Locale('es_ES');
        $translate = new Zend_Translate('array',
                    APPLICATION_PATH . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'languages',
                    null,
                    array('scan' => Zend_Translate::LOCALE_DIRECTORY));
        $registry = Zend_Registry::getInstance();
        $registry->set('Zend_Locale', $locale);
        $registry->set('Zend_Translate', $translate);
        $translate->setLocale($locale);

    }    


    protected function _initAcl() {
        
        $acl = new ProyectoZF_Acl();
        
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $front->registerPlugin(new ProyectoZF_Controller_Plugin_Acl($acl, $acl->_getRole()));        

        return $acl;
   
    }  
    
    protected function _initLayout()
    {
        $resource = $this->getPluginResource("layout");
        $layout = $resource->init();

        if ($this->hasResource('config')) {
            
            $config = $this->getResource('config');
            $layout->titulo = $config->parametros->titulo;              
            
        }

        return $layout;
    }       
    
    protected function _initView()
    {
        // for $view->baseUrl()
        $this->bootstrap('FrontController');
        $front = $this->getResource('FrontController');
        $request = new Zend_Controller_Request_Http();
        $front->setRequest($request);
        //
        
        $view = new Zend_View();
        
        if ($this->hasResource('config')) {
            $config = $this->getResource('config');  
            $view->doctype($config->parametros->doctype);
            $view->setEncoding($config->parametros->encoding);
            $view->headTitle($config->parametros->titulo);
            $view->headTitle()->setSeparator(' - ');
            $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
            $view->headMeta()->appendHttpEquiv('X-UA-Compatible', 'IE=Edge;chrome=1');
            $view->headMeta()->appendHttpEquiv('Content-Language', 'es-ES');
            
            $headLinksUrls = $config->parametros->css->toArray();
            foreach ($headLinksUrls as $val) {
                $view->headLink()->appendStylesheet($view->baseUrl() . (String)$val);
            } 
            
            $headScriptsUrls = $config->parametros->js->toArray();
            foreach ($headScriptsUrls as $val) {
                $view->headScript()->appendFile($view->baseUrl() . (String)$val);
            }             
            
        }        
        
        $view->addHelperPath('ProyectoZF/View/Helper/', 'ProyectoZF_View_Helper');                
                
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);

        return $view;
    }    
    
}  