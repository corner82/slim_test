<?php

namespace DAL\Factory\PDO;



class ReportConfigurationFactory implements \Zend\ServiceManager\FactoryInterface {
    
    
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        $reportConfiguration = new \DAL\PDO\ReportConfiguration();
        $slimApp = $serviceLocator->get('slimApp');
        //print_r($slimApp);
        $reportConfiguration->setSlimApp($slimApp);
        $reportConfiguration->fillGrid();
        return $reportConfiguration;
        
    }

}
