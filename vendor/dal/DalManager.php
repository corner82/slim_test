<?php

namespace DAL;

//use Zend\ServiceManager;

class DalManager extends \Zend\ServiceManager\ServiceManager {
    
    public function __construct(\Zend\ServiceManager\ConfigInterface $config = null) {
        parent::__construct($config);
    }
}
