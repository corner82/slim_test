<?php

namespace Utill\Forwarder;

class timeExpiredForwarder extends \Utill\Forwarder\abstractForwarder {
    public function __construct() {

    }
    
    public function redirect() {
        //ob_end_flush();
        /*ob_end_clean();
        $newURL = 'http://localhost/slim_redirect_test/index.php/hashNotMatch';
        header("Location: {$newURL}");*/
        
        ob_end_clean();  
        $ch = curl_init('http://localhost/slim_redirect_test/index.php/timeExpired');
        /*curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$content);*/

        $result = curl_exec($ch);
        curl_close($ch);
        exit();
        
    }
}
