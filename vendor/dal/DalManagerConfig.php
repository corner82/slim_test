<?php

namespace DAL;

class DalManagerConfig{
    
    /**
     * config array for zend service manager config
     * @var array
     */
    protected $config= array(
        // Initial configuration with which to seed the ServiceManager.
        // Should be compatible with Zend\ServiceManager\Config.
         'service_manager' => array(
             'invokables' => array(
                 //'test' => 'Utill\BLL\Test\Test'
             ),
             'factories' => [
                 'reportConfiguration' => 'DAL\Factory\PDO\ReportConfigurationFactory',
             ],  

         ),
     );
    
    public function __construct() {
        
    }
    
    /**
     * return config array for zend service manager config
     * @return array | null
     * @author Mustafa Zeynel Dağlı
     */
    public function getConfig() {
        return $this->config['service_manager'];
    }

}




