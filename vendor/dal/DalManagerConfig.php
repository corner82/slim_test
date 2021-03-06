<?php

/**
 * OSTİM TEKNOLOJİ Framework 
 * Ğİ
 * @link      https://github.com/corner82/slim_test for the canonical source repository
 * @copyright Copyright (c) 2015 OSTİM TEKNOLOJİ (http://www.ostim.com.tr)
 * @license   
 */

namespace DAL;

/**
 * class called for DAL manager config 
 * DAL manager uses Zend Service manager and 
 * config class is compliant zend service config structure
 * @author Mustafa Zeynel Dağlı
 */
class DalManagerConfig {

    /**
     * constructor
     */
    public function __construct() {
        
    }

    /**
     * config array for zend service manager config
     * @var array
     */
    protected $config = array(
        // Initial configuration with which to seed the ServiceManager.
        // Should be compatible with Zend\ServiceManager\Config.
        'service_manager' => array(
            'invokables' => array(
            //'test' => 'Utill\BLL\Test\Test'
            ),
            'factories' => [
                'reportConfigurationPDO' => 'DAL\Factory\PDO\ReportConfigurationFactory',
                'cmpnyEqpmntPDO' => 'DAL\Factory\PDO\CmpnyEqpmntFactory',
                'sysNavigationLeftPDO' => 'DAL\Factory\PDO\SysNavigationLeftFactory',
                'sysSectorsPDO' => 'DAL\Factory\PDO\SysSectorsFactory',
                'infoUsersPDO' => 'DAL\Factory\PDO\InfoUsersFactory',
                'sysCountrysPDO' => 'DAL\Factory\PDO\SysCountrysFactory',
                'sysCityPDO' => 'DAL\Factory\PDO\SysCityFactory',
                'sysLanguagePDO' => 'DAL\Factory\PDO\SysLanguageFactory',
                'sysBoroughPDO' => 'DAL\Factory\PDO\SysBoroughFactory',
                'sysVillagePDO' => 'DAL\Factory\PDO\SysVillageFactory',      
                'blLoginLogoutPDO' => 'DAL\Factory\PDO\BlLoginLogoutFactory',    
                
            ],
        ),
    );

    /**
     * return config array for zend service manager config
     * @return array | null
     * @author Mustafa Zeynel Dağlı
     */
    public function getConfig() {
        return $this->config['service_manager'];
    }

}
