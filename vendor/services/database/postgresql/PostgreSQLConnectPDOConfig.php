<?php

namespace Services\Database\Postgresql;

class PostgreSQLConnectPDOConfig {
    
    /**
     * PDO connection configuration options,
     * @var array
     */
    public static $config = array(
            /*\PDO::ATTR_PERSISTENT => true*/);
    
    /**
     * returns static config array
     * @return array | null
     */
    public static function getConfig() {
        return self::$config;
    }
    
    
}

