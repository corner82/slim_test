<?php
// test commit for branch slim2
require 'vendor/autoload.php';



/*$app = new \Slim\Slim(array(
    'mode' => 'development',
    'debug' => true,
    'log.enabled' => true,
    ));*/

$app = new \Slim\SlimExtended(array(
    'mode' => 'development',
    'debug' => true,
    'log.enabled' => true,
    'log.level' => \Slim\Log::INFO,
    'exceptions.rabbitMQ' => true,
    'exceptions.rabbitMQ.logging' => \Slim\SlimExtended::LOG_RABBITMQ_FILE,
    'exceptions.rabbitMQ.queue.name' => \Slim\SlimExtended::EXCEPTIONS_RABBITMQ_QUEUE_NAME
    ));

/**
 * "Cross-origion resource sharing" kontrolüne izin verilmesi için eklenmiştir
 * @author Mustafa Zeynel Dağlı
 * @since 2.10.2015
 */
$res = $app->response();
$res->header('Access-Control-Allow-Origin', '*');
$res->header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");

//$app->add(new \Slim\Middleware\MiddlewareTest());
$app->add(new \Slim\Middleware\MiddlewareServiceManager());
$app->add(new \Slim\Middleware\MiddlewareHMAC());


$pdo = new PDO('pgsql:dbname=ecoman_01_10;host=88.249.18.205;user=postgres;password=1q2w3e4r');

\Slim\Route::setDefaultConditions(array(
    'firstName' => '[a-zA-Z]{3,}',
    'page' => '[0-9]{1,}'
));    

$app->get('/hello/:name/:firstName', function ($name) {
    echo "Hello, $name";
});

$app->post('/hello/:name/:firstName', function ($name) {
    echo "Hello, $name";
});





/**
 *  * zeynel daÄŸlÄ±
 * @since 11-09-2014
 */
$app->get("/getReports_test/", function () use ($app, $pdo) {
    //$pdo->exec('SET NAMES "utf8"');
    //$res = $pdo->query(  "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = 'ecoman_18_08' AND TABLE_NAME = 't_flow';"  )->fetchAll(PDO::FETCH_ASSOC);
    /*if(isset($_GET['flows']) && $_GET['flows']!="" ) {
        $flows = json_decode($_GET['flows'], true);
        //print_r($flows);
        $flowsStr="";
        foreach ($flows as $key=>$value){
            $flowsStr.= $value.',';
        }
        $flowsStr = rtrim($flowsStr, ',');
    } */
    //echo $flowsStr;
    

    
    //print_r($app->container['request']);
    $requestObj = $app->container['request'];
    //print_r($requestObj->params());
    //print_r($requestObj->isXhr());
    
    
    if(isset($_GET['page']) && $_GET['page']!="" && isset($_GET['rows']) && $_GET['rows']!="") {
        $offset = ((intval($_GET['page'])-1)* intval($_GET['rows']));
        $limit = intval($_GET['rows']);
    } else {
        $limit = 10;
        $offset = 0;
    }
    
    $sortArr = array();
    $orderArr = array();
    if(isset($_GET['sort']) && $_GET['sort']!="") {
        $sort = trim($_GET['sort']);
        $sortArr = explode(",", $sort);
        //print_r($sortArr);
        if(count($sortArr)===1)$sort = trim($_GET['sort']);
    } else {
        //$sort = "id";
        $sort = "r_date";
    }
    
    if(isset($_GET['order']) && $_GET['order']!="") {
        $order = trim($_GET['order']);
        $orderArr = explode(",", $order);
        //print_r($orderArr);
        if(count($orderArr)===1)$order = trim($_GET['order']);
    } else {
        //$order = "desc";
        $order = "ASC";
    }
    
    if(count($sortArr)===2 AND count($orderArr)===2) {
        $sort = $sortArr[0]. " ".$orderArr[0].", ";
        $order = $sortArr[1]. " ".$orderArr[1];
    } 
    
    if(isset($_GET['prj_id']) && $_GET['prj_id']!="" && $_GET['prj_id']!=-1) {
        $projectID = $_GET['prj_id'];
        $projectStr = '   cm.id IN ( SELECT cmpny_id FROM t_prj_cmpny WHERE prj_id = '.$projectID.'  )';
    } else {
        $projectID = '';
        $projectStr = '';
    }
    /*print_r("SELECT 
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
                            c.name as company_name
                            FROM r_report_used_configurations rp
                            INNER JOIN t_user u ON rp.user_id=u.id
                            INNER JOIN t_cmpny c ON rp.company_id=c.id
                            ORDER BY  ".$sort." ".$order." LIMIT ".$limit." OFFSET ".$offset." 
                            ; ");*/
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
                            INNER JOIN t_cmpny c ON rp.company_id=c.id
                            ORDER BY  ".$sort." ".$order." LIMIT ".$limit." OFFSET ".$offset." ;
                          ")->fetchAll(PDO::FETCH_ASSOC);
                            //ORDER BY  ".$order." ".$sort." LIMIT ".$offset.",".$limit."
    $res2 = $pdo->query(  "
                            SELECT 
                            count(rp.id) as toplam
                            FROM r_report_used_configurations rp
                            INNER JOIN t_user u ON rp.user_id=u.id
                            INNER JOIN t_cmpny c ON rp.company_id=c.id
                            "  )->fetchAll(PDO::FETCH_ASSOC);
    $flows = array();
    foreach ($res as $flow){
        $flows[]  = array(
            "id" => $flow["id"],
            "report_name" => $flow["report_name"],
            "r_date" => $flow["r_date"],
            "user_name" => $flow["user_name"],
            "name" => $flow["name"],
            "surname" => $flow["surname"],
            "company_name" => $flow["company_name"],
            "company_id" => $flow["company_id"],
            
        );
    }
    
    //{field:'opportunity',title:'Opportunity',width:80},
    
    
    $app->response()->header("Content-Type", "application/json");
    
    $resultArray = array();
    $resultArray['total'] = $res2[0]['toplam'];
    $resultArray['rows'] = $flows;
    
    /*$app->contentType('application/json');
    $app->halt(302, '{"error":"Something went wrong"}');
    $app->stop();*/
    
    //fopen('zeyn.txt');
    echo json_encode($resultArray);
    
});




$app->run();