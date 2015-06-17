<?php

namespace Utill\Env;

class serverVariables {
    public function __construct() {
        
    }
    
    /**
     * get client ip adress whereever it is located
     * @return strıng
     * @author Mustafa Zeynel Dağlı
     */
    public static function  getClientIp() {
    $ipaddress = '';
    if ($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
}

