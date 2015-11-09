<?php

namespace DAL;

abstract class AbstractDalSlimm extends AbstractDal
                                implements \DAL\DalInterface, \Slim\SlimAppInterface {
    
    /**
     * Slim application instance
     * @var Slim\Slim
     */
    protected $slimApp;
    
    public function getSlimApp() {
        return $this->slimApp;
    }

    public function setSlimApp(\Slim\Slim $slimApp) {
        $this->slimApp = $slimApp;
    }
}
