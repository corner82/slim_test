<?php

namespace DAL;

interface DalManagerInterface {
    /**
     * injects Dal manager instance extended from Zend
     * service manager instance in Slimm Application
     * @param \Zend\ServiceManager\ServiceLocatorInterface $serviceManager
     * @author Mustafa Zeynel Dağlı
     */
    public function setDalManager(\Zend\ServiceManager\ServiceLocatorInterface $serviceManager);
    
    /**
     * gets Dal manager instance extended from 
     * Zend service manager instance from Slimm Application
     * @return \Zend\ServiceManager\ServiceLocatorInterface
     * @author Mustafa Zeynel Dağlı
     */
    public function getDAlManager();
}

