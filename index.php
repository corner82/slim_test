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
$app->add(new \Slim\Middleware\MiddlewareBLLManager());
$app->add(new \Slim\Middleware\MiddlewareDalManager());
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

$app->get("/getDynamicForm_test/", function () use ($app) {
    $app->response()->header("Content-Type", "text/html");
    
    /*use PFBC\Form;
    use PFBC\Element;*/
    
    $options = array("Option #1", "Option #2", "Option #3");
    $form = new \PFBC\Form("form-elements");
    $form->clearValues();
    $form->configure(array(
            "prevent" => array("bootstrap", "jQuery")
    ));
    $form->addElement(new \PFBC\Element\Hidden("form", "form-elements"));
    $form->addElement(new \PFBC\Element\HTML('<legend>Standard</legend>'));
    $form->addElement(new \PFBC\Element\Textbox("Textbox:", "Textbox", array("onclick" => "alert('test alert');",
                                                                        'id' => 'test',
                                                                        'class' => 'zeynel')));
    $form->addElement(new \PFBC\Element\Password("Password:", "Password"));
    $form->addElement(new \PFBC\Element\File("File:", "File"));
    $form->addElement(new \PFBC\Element\Textarea("Textarea:", "Textarea"));
    $form->addElement(new \PFBC\Element\Select("Select:", "Select", $options));
    $form->addElement(new \PFBC\Element\Radio("Radio Buttons:", "RadioButtons", $options));
    $form->addElement(new \PFBC\Element\Checkbox("Checkboxes:", "Checkboxes", $options));
    /*$form->addElement(new Element\HTML('<legend>HTML5</legend>'));
    $form->addElement(new Element\Phone("Phone:", "Phone"));
    $form->addElement(new Element\Search("Search:", "Search"));
    $form->addElement(new Element\Url("Url:", "Url"));
    $form->addElement(new Element\Email("Email:", "Email"));
    $form->addElement(new Element\Date("Date:", "Date"));
    $form->addElement(new Element\DateTime("DateTime:", "DateTime"));
    $form->addElement(new Element\DateTimeLocal("DateTime-Local:", "DateTimeLocal"));
    $form->addElement(new Element\Month("Month:", "Month"));
    $form->addElement(new Element\Week("Week:", "Week"));
    $form->addElement(new Element\Time("Time:", "Time"));
    $form->addElement(new Element\Number("Number:", "Number"));
    $form->addElement(new Element\Range("Range:", "Range"));
    $form->addElement(new Element\Color("Color:", "Color"));
    $form->addElement(new Element\HTML('<legend>jQuery UI</legend>'));
    $form->addElement(new Element\jQueryUIDate("Date:", "jQueryUIDate"));
    $form->addElement(new Element\Checksort("Checksort:", "Checksort", $options));
    $form->addElement(new Element\Sort("Sort:", "Sort", $options));
    $form->addElement(new Element\HTML('<legend>WYSIWYG Editor</legend>'));
    $form->addElement(new Element\TinyMCE("TinyMCE:", "TinyMCE"));
    $form->addElement(new Element\CKEditor("CKEditor:", "CKEditor"));
    $form->addElement(new Element\HTML('<legend>Custom/Other</legend>'));
    $form->addElement(new Element\State("State:", "State"));
    $form->addElement(new Element\Country("Country:", "Country"));
    $form->addElement(new Element\YesNo("Yes/No:", "YesNo"));
    $form->addElement(new Element\Captcha("Captcha:"));
    $form->addElement(new Element\Button);
    $form->addElement(new Element\Button("Cancel", "button", array(
            "onclick" => "history.go(-1);"
    )));*/
    echo $form->render(true);
    //echo htmlentities($form->render(true), ENT_QUOTES);

    
    //echo "<div><input type='text' value='deneme' ></></div>";
    }
);



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
    
    //$app->getServiceManager()->get('pgConnectFactory');
    //print_r($app->getServiceManager()->get('pgConnectFactory')); 
    
    //print_r($app->container['request']);
    $requestObj = $app->container['request'];
    //print_r($requestObj->params());
    //print_r($requestObj->isXhr());
    
    //$app->getDalManager()->get('reportConfigurationPDO');
    //$this->app->getServiceManager()->get('test');
    //$app->getServiceManager()->get('pgConnectFactory'); 
    $BLL = $app->getBLLManager()->get('reportConfigurationBLL'); 
    $BLL->test();
    
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
    $app->getServiceManager()->get('test'); 
    
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