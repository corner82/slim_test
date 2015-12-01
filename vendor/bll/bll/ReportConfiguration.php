<?php

namespace BLL\BLL;

class ReportConfiguration extends \BLL\BLLSlim{
    
    public function __construct() {
        //parent::__construct();
    }
    
    public function test() {
        //$DAL = $this->slimApp->getDALManager()->get('reportConfigurationPDO');
        //$DAL->test();
    }
    
    public function insert($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('reportConfigurationPDO');
        return $DAL->insert($params);
    }
    
    public function update($id = null, $params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('reportConfigurationPDO');
        return $DAL->update($id, $params);
    }
    
    public function delete($id = null) {
        $DAL = $this->slimApp->getDALManager()->get('reportConfigurationPDO');
        return $DAL->delete($id);
    }

    public function getAll() {
        $DAL = $this->slimApp->getDALManager()->get('reportConfigurationPDO');
        return $DAL->getAll();
    }
    
    public function fillGrid ($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('reportConfigurationPDO');
        $resultSet = $DAL->fillGrid($params);  
        return $resultSet['resultSet'];
    }
    
    public function fillGridRowTotalCount($params = array()) {
        $DAL = $this->slimApp->getDALManager()->get('reportConfigurationPDO');
        $resultSet = $DAL->fillGridRowTotalCount($params);  
        return $resultSet['resultSet'];
    }

}

