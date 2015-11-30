<?php

namespace DAL;

 class DalSlim extends AbstractDal
                                implements  \Slim\SlimAppInterface {
    
    /**
     * Slim application instance
     * @var Slim\Slim
     */
    protected $slimApp;
    
    /**
     * return slim app
     * @return Slim\Slim
     */
    public function getSlimApp() {
        return $this->slimApp;
    }

    /**
     * sets slim app
     * @param \Slim\Slim $slimApp
     */
    public function setSlimApp(\Slim\Slim $slimApp) {
        $this->slimApp = $slimApp;
    }

    public function delete($id = null) {
        
    }

    public function getAll() {
        
    }

    public function insert($params = array()) {
        
    }

    public function update($id = null, $params = array()) {
        
    }

}
