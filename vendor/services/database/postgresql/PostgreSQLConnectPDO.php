<?php

namespace Services\Database\Postgresql;

use Zend\ServiceManager\ServiceLocatorInterface;

class PostgreSQLConnectPDO implements \Zend\ServiceManager\FactoryInterface {
    
    
    public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        try {
            $pdo = new \PDO('pgsql:dbname=ecoman_01_10;host=88.249.18.205;',
                            'postgres',
                            '1q2w3e4r',
                            PostgreSQLConnectPDOConfig::getConfig());
            return $pdo;
        } catch (PDOException $e) {
            return false;
        } 


    }

}
