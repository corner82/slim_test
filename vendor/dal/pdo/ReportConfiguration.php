<?php

namespace DAL\PDO;

class ReportConfiguration extends \DAL\AbstractDalSlimm {
    
    public function test() {
        //print_r('--test DAl Object--');
    }


    public function delete($id = null) {
        
    }

    public function getAll() {
        
    }

    public function insert($params = array()) {
        
    }

    public function update($id = null) {
        
    }
    
    public function fillGrid($args = array()) {
        $pdo = $this->slimApp->getServiceManager()->get('pgConnectFactory');
        //print_r($pdo);
        $res = $pdo->query("
                        SELECT 
                            rp.id as id, 
                            rp.project_id as project_id, 
                            rp.user_id as user_id, 
                            rp.report_jasper_id as report_jasper_id, 
                            rp.report_type_id as report_type_id, 
                            rp.r_date as r_date, 
                            rp.report_name as report_name,
                            u.user_name as user_name,
                            u.surname as surname,
                            u.name as name,
                            c.name as company_name,
                            c.id as company_id
                            FROM r_report_used_configurations rp
                            INNER JOIN t_user u ON rp.user_id=u.id
                            INNER JOIN t_cmpny c ON rp.company_id=c.id ;
            ")->fetchAll(\PDO::FETCH_ASSOC);
        //print_r($res);
            //ORDER BY  ".$order." ".$sort." LIMIT ".$offset.",".$limit."
        
        
    }

    

    

}

