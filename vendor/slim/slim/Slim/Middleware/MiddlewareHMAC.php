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
  class MiddlewareHMAC extends \Slim\Middleware implements \Slim\Interfaces\interfaceRequestParams, 
                                                            \Slim\Interfaces\interfaceRequest,
                                                            \Slim\Interfaces\interfaceRequestCustomHeaderData
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
     * App request parameters
     * @var array
     */
    protected $appRequestParams = array();
    
    /**
     * App request object
     * @var \Slim\Http\Request
     */
    protected $requestObj;

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
    public function getRequestHeaderData()  {
        if($this->requestHeaderData == null)   {
            $this->setRequestHeaderData();
            return $this->requestHeaderData;
        } else {
            return $this->requestHeaderData;
        }
    }
    
    /**
     * set request custom header info into array
     * @return array
     * @author Mustafa Zeynel Dağlı
     * @link http://php.net/manual/en/function.getallheaders.php
     */
    public function setRequestHeaderData($requestHeaderData = array())  {
        $requestObj = $this->getAppRequest();
        return $this->requestHeaderData = $requestObj->headers();
    }
    
    /**
     * Call
     */
    public function call()
    {
        print_r('MiddlewareHMAC middleware call method------');
        print_r($this->getRequestHeaderData());
        print_r($this->requestHeaderData['X-Hash']);
        $hmac = new \HMAC\HmacTest();
        //print_r($this->getAppRequestParams());
        //print_r($this->getAppRequest());
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

    public function getAppRequestParams() {
        if(empty($this->appRequestParams)) $this->appRequestParams = $this->setAppRequestParams();
        return $this->appRequestParams;
    }

    public function setAppRequestParams($appRequestParams = array()) {
        $requestHeaderData = [];
        $request = $this->app->container['request'];
        return $request->params();
        //return $this->app['request']->params();
    }

    /**
     * get Application request object
     * @return \Slim\Http\Request
     * @author Mustafa Zeynel Dağlı
     */
    public function getAppRequest() {
        if($this->requestObj == null) $this->requestObj = $this->setAppRequest();
        return $this->requestObj;
    }

    /**
     * set Application request object
     * @return \Slim\Http\Request
     * @author Mustafa Zeynel Dağlı
     */
    public function setAppRequest(\Slim\Http\Request $request = null) {
        return $this->app->container['request'];
        
    }

}