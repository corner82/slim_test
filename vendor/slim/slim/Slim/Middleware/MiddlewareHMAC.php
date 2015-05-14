<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Slim\Middleware;
 
 /**
  * Flash
  *
  * This is middleware for a Slim application that enables
  * Flash messaging between HTTP requests. This allows you
  * set Flash messages for the current request, for the next request,
  * or to retain messages from the previous request through to
  * the next request.
  *
  * @package    Slim
  * @author     Josh Lockhart
  * @since      1.6.0
  */
  class MiddlewareHMAC extends \Slim\Middleware 
{
    /**
     * @var array
     */
    protected $settings;

    /**
     * @var array
     */
    protected $messages;
    
    /**
     * request header data
     * @var array
     */
    protected $requestHeaderData;

    /**
     * Constructor
     * @param  array  $settings
     */
    public function __construct($settings = array())
    {
        
        
    }
    
    /**
     * get request custom header info
     * @return array | null
     * @author Mustafa Zeynel Dağlı
     */
    protected function getRequestHeaderData()  {
        if($this->requestHeaderData == null) $this->requestHeaderData = $this->setRequestHeaderData();
        return $this->requestHeaderData;
    }
    
    /**
     * set request custom header info into array
     * @return array
     * @author Mustafa Zeynel Dağlı
     */
    protected function setRequestHeaderData()  {
        $requestHeaderData = [];
        if (function_exists("getallheaders")) {
            $requestHeaderData = getallheaders();
        } else {
            $requestHeaderData = $this->getRequestHeadersFastCGI();
        }
       
        return $requestHeaderData;
    }
    
    /**
     * when requesting custom header info on ngix servers,
     * if not loaded as fastGCI module 'getallheaders' function cannot be used,
     * also also 'getallheaders' can be used in fastGCI module as PHP 5.4 version and above.
     * So this is an helper function to het custom header info 
     * @link http://php.net/manual/en/function.getallheaders.php#84262
     * @return array
     * @author Mustafa Zeynel Dağlı
     */
    private function getRequestHeadersFastCGI () {
       $headers = array(); 
       foreach ($_SERVER as $name => $value) 
       { 
           if (substr($name, 0, 5) == 'HTTP_') 
           { 
               $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value; 
           } 
       } 
       return $headers; 
        
    }
        
        

    /**
     * Call
     */
    public function call()
    {
        print_r('MiddlewareHMAC middleware call method------');
        print_r($this->getRequestHeaderData());
            $publicHash = '3441df0babc2a2dda551d7cd39fb235bc4e09cd1e4556bf261bb49188f548348';
            $privateHash = 'e249c439ed7697df2a4b045d97d4b9b7e1854c3ff8dd668c779013653913572e';
            $content    = json_encode(array(
                'test' => 'content'
            ));
            
            //$this->app->setPublicHash('3441df0babc2a2dda551d7cd39fb235bc4e09cd1e4556bf261bb49188f548348');
            
            //
            //print_r("------public hash---------".$this->app->getPublicHash()."------public hash---------");

            /*$hash = hash_hmac('sha256', $content, $privateHash);

            $headers = array(
                'X-Public: '.$publicHash,
                'X-Hash: '.$hash
            );
            //ob_flush();
            
            
            $ch = curl_init('http://localhost/slim_redirect_test/index.php/redirected_path');
            curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$content);

            $result = curl_exec($ch);
            curl_close($ch);*/
            
            //ob_end_flush();
            /*ob_end_clean();
            $newURL = 'http://localhost/slim_redirect_test/index.php/redirected_path';
            header("Location: {$newURL}");*/
         
            
        
        
        
        
        $this->next->call();
        //$this->save();
    }

}