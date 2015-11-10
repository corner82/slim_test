<?php

namespace BLL;

class BLLSlim extends \BLL\AbstractBLL implements 
                                            \Slim\SlimAppInterface{
    
    public function __construct() {
        
    }

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
}

