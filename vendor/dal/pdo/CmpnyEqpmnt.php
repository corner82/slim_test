<?php

/**
 * OSTİM TEKNOLOJİ Framework 
 *
 * @link      https://github.com/corner82/slim_test for the canonical source repository
 * @copyright Copyright (c) 2015 OSTİM TEKNOLOJİ (http://www.ostim.com.tr)
 * @license   
 */

namespace DAL\PDO;

/* CmpnyEqpmnt()
 * ======  
 * @type class     
 * Auhtor: Okan CIRAN
 *  
 * Date: 2.12.2015
 */

class CmpnyEqpmnt extends \DAL\DalSlim {
    /* CmpnyEqpmnt tablosunda delete()
     * ======  
     * @type function
     * Auhtor: Okan CIRAN
     * CmpnyEqpmnt tablosundan parametre olarak  gelen id kaydını siler. !!
     * Date: 04.12.2015
     */

    public function delete($id = null) {
        try {
            $pdo = $this->slimApp->getServiceManager()->get('pgConnectFactory');
            $pdo->beginTransaction();

            $statement = $pdo->prepare("Delete from t_cmpny_eqpmnt where id = :id");
            $statement->bindValue(':id', $id, \PDO::PARAM_INT);

            $update = $statement->execute();
            $afterRows = $statement->rowCount();
            $errorInfo = $statement->errorInfo();

            if ($errorInfo[0] != "00000" && $errorInfo[1] != NULL && $errorInfo[2] != NULL)
                throw new \PDOException($errorInfo[0]);
            $pdo->commit();
            return array("found" => true, "errorInfo" => $errorInfo, "affectedRowsCount" => $afterRows);
        } catch (\PDOException $e /* Exception $e */) {
            $pdo->rollback();
            return array("found" => false, "errorInfo" => $e->getMessage());
        }
    }

    /* CmpnyEqpmnt tablosundan getAll()
     * ======  
     * @type function
     * Auhtor: Okan CIRAN
     * CmpnyEqpmnt tablosundaki tüm kayıtları getirir.  !!
     * Date: 04.12.2015
     */

    public function getAll() {
        try {
            $pdo = $this->slimApp->getServiceManager()->get('pgConnectFactory');

            $statement = $pdo->prepare("SELECT id, cmpny_id, eqpmnt_id, eqpmnt_type_id, eqpmnt_type_attrbt_id, 
                            eqpmnt_attrbt_val, eqpmnt_attrbt_unit  FROM t_cmpny_eqpmnt 
                       ");
            $statement->execute();
            $result = $statement->fetcAll(\PDO::FETCH_ASSOC);
            $errorInfo = $statement->errorInfo();
            if ($errorInfo[0] != "00000" && $errorInfo[1] != NULL && $errorInfo[2] != NULL)
                throw new \PDOException($errorInfo[0]);
            return array("found" => true, "errorInfo" => $errorInfo, "resultSet" => $result);
        } catch (\PDOException $e /* Exception $e */) {
            $pdo->rollback();
            return array("found" => false, "errorInfo" => $e->getMessage());
        }
    }

    /* CmpnyEqpmnt tablosunda insert()
     * ======  
     * @type function
     * Auhtor: Okan CIRAN
     * CmpnyEqpmnt tablosuna yeni bir kayıt oluşturur.  !!
     * Date: 04.12.2015
     */

    public function insert($params = array()) {
        try {
            $pdo = $this->slimApp->getServiceManager()->get('pgConnectFactory');
            $pdo->beginTransaction();

            $statement = $pdo->prepare("INSERT INTO t_cmpny_eqpmnt(
                    cmpny_id, 
                    eqpmnt_id, 
                    eqpmnt_type_id, 
                    eqpmnt_type_attrbt_id, 
                    eqpmnt_attrbt_val, 
                    eqpmnt_attrbt_unit)
                    VALUES ( 
                        :cmpny_id, 
                        :eqpmnt_id, 
                        :eqpmnt_type_id, 
                        :eqpmnt_type_attrbt_id, 
                        :eqpmnt_attrbt_val, 
                        :eqpmnt_attrbt_unit )
                                    ");

            $statement->bindValue(':cmpny_id', $params['cmpny_id'], \PDO::PARAM_INT);
            $statement->bindValue(':eqpmnt_id', $params['eqpmnt_id'], \PDO::PARAM_INT);
            $statement->bindValue(':eqpmnt_type_id', $params['eqpmnt_type_id'], \PDO::PARAM_INT);
            $statement->bindValue(':eqpmnt_type_attrbt_id', $params['eqpmnt_type_attrbt_id'], \PDO::PARAM_INT);
            $statement->bindValue(':eqpmnt_attrbt_val', $params['eqpmnt_attrbt_val'], \PDO::PARAM_INT);
            $statement->bindValue(':eqpmnt_attrbt_unit', $params['eqpmnt_attrbt_unit'], \PDO::PARAM_INT);

            $result = $statement->execute();

            $insertID = $pdo->lastInsertId('t_activity_id_seq');

            $errorInfo = $statement->errorInfo();
            if ($errorInfo[0] != "00000" && $errorInfo[1] != NULL && $errorInfo[2] != NULL)
                throw new \PDOException($errorInfo[0]);
            $pdo->commit();

            return array("found" => true, "errorInfo" => $errorInfo, "lastInsertId" => $insertID);
        } catch (\PDOException $e /* Exception $e */) {
            $pdo->rollback();
            return array("found" => false, "errorInfo" => $e->getMessage());
        }
    }

    /* CmpnyEqpmnt tablosunda update()
     * ======  
     * @type function
     * Auhtor: Okan CIRAN
     * CmpnyEqpmnt tablosuna parametre olarak gelen id deki kaydı bilgilerini günceller   !!
     * Date: 04.12.2015
     */

    public function update($id = null, $params = array()) {
        try {

            $pdo = $this->slimApp->getServiceManager()->get('pgConnectFactory');
            $pdo->beginTransaction();
            $statement = $pdo->prepare("UPDATE t_cmpny_eqpmnt
                    SET 
                        cmpny_id = :cmpny_id, 
                        eqpmnt_id = :eqpmnt_id, 
                        eqpmnt_type_id = :eqpmnt_type_id, 
                        eqpmnt_type_attrbt_id = :eqpmnt_type_attrbt_id, 
                        eqpmnt_attrbt_val = :eqpmnt_attrbt_val, 
                        eqpmnt_attrbt_unit = :eqpmnt_attrbt_unit 
                    WHERE id = :id");

            $statement->bindValue(':id', $id, \PDO::PARAM_INT);
            $statement->bindValue(':cmpny_id', $params['cmpny_id'], \PDO::PARAM_INT);
            $statement->bindValue(':eqpmnt_id', $params['eqpmnt_id'], \PDO::PARAM_INT);
            $statement->bindValue(':eqpmnt_type_id', $params['eqpmnt_type_id'], \PDO::PARAM_INT);
            $statement->bindValue(':eqpmnt_type_attrbt_id', $params['eqpmnt_type_attrbt_id'], \PDO::PARAM_INT);
            $statement->bindValue(':eqpmnt_attrbt_val', $params['eqpmnt_attrbt_val'], \PDO::PARAM_INT);
            $statement->bindValue(':eqpmnt_attrbt_unit', $params['eqpmnt_attrbt_unit'], \PDO::PARAM_INT);

            $update = $statement->execute();
            $affectedRows = $statement->rowCount();
            $errorInfo = $statement->errorInfo();
            if ($errorInfo[0] != "00000" && $errorInfo[1] != NULL && $errorInfo[2] != NULL)
                throw new \PDOException($errorInfo[0]);
            $pdo->commit();
            return array("found" => true, "errorInfo" => $errorInfo, "affectedRowsCount" => $affectedRows);
        } catch (\PDOException $e /* Exception $e */) {
            $pdo->rollback();
            return array("found" => false, "errorInfo" => $e->getMessage());
        }
    }

    /* CmpnyEqpmnt tablosunda update()
     * ======  
     * @type function
     * Auhtor: Okan CIRAN
     * CmpnyEqpmnt tablosuna parametre olarak gelen id deki kaydı bilgilerini günceller   !!
     * Date: 04.12.2015
     */

    public function fillGrid($args = array()) {


        if (isset($args['page']) && $args['page'] != "" && isset($args['rows']) && $args['rows'] != "") {
            $offset = ((intval($args['page']) - 1) * intval($args['rows']));
            $limit = intval($args['rows']);
        } else {
            $limit = 10;
            $offset = 0;
        }

        $sortArr = array();
        $orderArr = array();
        if (isset($args['sort']) && $args['sort'] != "") {
            $sort = trim($args['sort']);
            $sortArr = explode(",", $sort);
            if (count($sortArr) === 1)
                $sort = trim($args['sort']);
        } else {
            //$sort = "id";
            $sort = "r_date";
        }

        if (isset($args['order']) && $args['order'] != "") {
            $order = trim($args['order']);
            $orderArr = explode(",", $order);
            //print_r($orderArr);
            if (count($orderArr) === 1)
                $order = trim($args['order']);
        } else {
            //$order = "desc";
            $order = "ASC";
        }


        try {
            $pdo = $this->slimApp->getServiceManager()->get('pgConnectFactory');
     $sql = "SELECT 
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
                        INNER JOIN t_cmpny c ON rp.company_id=c.id
                        ORDER BY  ".$sort." "
                        . "".$order." "  
                        . "LIMIT ".$pdo->quote($limit)." "
                        . "OFFSET ".$pdo->quote($offset)." ";
            $statement = $pdo->prepare($sql);


            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $errorInfo = $statement->errorInfo();
            
             if($errorInfo[0]!="00000" && $errorInfo[1]!=NULL && $errorInfo[2]!=NULL ) throw new \PDOException($errorInfo[0]);
            return array("found"=>true,"errorInfo"=>$errorInfo,"resultSet"=>$result);
            
        } catch (\PDOException $e /* Exception $e */) {
            //$debugSQLParams = $statement->debugDumpParams();
            return array("found" => false, "errorInfo" => $e->getMessage()/* , 'debug' => $debugSQLParams */);
        }
    }
    
    
    
      public function fillGridRowTotalCount($params = array()) {
        try {
            $pdo = $this->slimApp->getServiceManager()->get('pgConnectFactory');
             $sql = "
                 SELECT count(id)  as toplam  FROM t_cmpny_eqpmnt
                    ";
            $statement = $pdo->prepare($sql);
            $statement->execute();
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

            $errorInfo = $statement->errorInfo();
            if($errorInfo[0]!="00000" && $errorInfo[1]!=NULL && $errorInfo[2]!=NULL ) throw new \PDOException($errorInfo[0]);
            return array("found"=>true,"errorInfo"=>$errorInfo,"resultSet"=>$result);
            
            
            
         }catch(\PDOException $e /*Exception $e*/) {  
           //$debugSQLParams = $statement->debugDumpParams();
           return array("found"=>false,"errorInfo"=>$e->getMessage()/*, 'debug' => $debugSQLParams*/);
        }
      }
}
