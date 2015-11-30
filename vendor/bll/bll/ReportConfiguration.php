<?php

namespace BLL\BLL;

class ReportConfiguration extends \BLL\BLLSlim{
    
    public function __construct() {
        //parent::__construct();
    }
    
    public function test() {
        $DAL = $this->slimApp->getDALManager()->get('reportConfigurationPDO');
        $DAL->test();
    }
    
    public function fillReportConfigGrid($args = array()) {
        $DAL = $this->slimApp->getDALManager()->get('reportConfigurationPDO');
        $DAL->fillGrid($args);
    }

}

