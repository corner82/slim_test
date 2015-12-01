<?php
/**
 * OSTİM TEKNOLOJİ Framework (http://framework.zend.com/)
 *
 * @link      https://github.com/corner82/slim_test for the canonical source repository
 * @copyright Copyright (c) 2015 OSTİM TEKNOLOJİ (http://www.ostim.com.tr)
 * @license   
 */

namespace BLL\BLL;

/**
 * Business Layer class for report Configuration entity
 */
class ReportConfiguration extends \BLL\BLLSlim{
    
    /**
     * constructor
     */
    public function __construct() {
        //parent::__construct();
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

