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
     * hmac object
     * @var \Hmac\Hmac
     */
    protected $hmacObj;
    
    /**
     * request expire time as seconds
     * @var int
     */
    protected $requestExpireTime = 60;

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
        $this->evaluateExpireTime();
        $this->evaluateHash();
        $this->next->call();
    }
    
    protected function calcExpireTime() {
        
    }
    
     /**
     * get hmacObj
     * @author Okan Cıran
     */
      private function getHmacObj() {            
      if ($this->hmacObj == null) { 
            $this->setHmacObj();          
      } else {
            return $this->hmacObj;
      }       
    }  
    
    /**
     * set hmacObj
     * @author Okan Cıran
     */
     private function setHmacObj() {            
        $this->hmacObj = new \HMAC\Hmac();       
     } 
     
    /**
     * get info to calculate HMAC security measures
     * @author Mustafa Zeynel Dağlı
     */
    private function evaluateHash() {
        $this->getHmacObj();
        $this->hmacObj->setRequestParams($this->getAppRequestParams());
        $this->hmacObj->setPublicKey($this->getRequestHeaderData()['X-Public']);
        $this->hmacObj->setNonce($this->getRequestHeaderData()['X-Nonce']);
        // bu private key kısmı veri tabanından alınır hale gelecek
        $this->hmacObj->setPrivateKey('e249c439ed7697df2a4b045d97d4b9b7e1854c3ff8dd668c779013653913572e');
        $this->hmacObj->makeHmac();
        
        //print_r($hmacObj->getHash()); 
        
        if($this->hmacObj->getHash() != $this->getRequestHeaderData()['X-Hash'])  {
            //print_r ('-----hash eşit değil----');
            $hashNotMatchForwarder = new \Utill\Forwarder\hashNotMatchForwarder();
            $hashNotMatchForwarder->redirect();
            
        } else {
           //print_r ('-----hash eşit ----'); 
        }
    }
    
    /**
     * get time difference
     * @author Okan Cıran
     */
    private function evaluateExpireTime() { 
        $this->getHmacObj();
        $encryptClass = $this->app->setEncryptClass();
        $this->hmacObj->setTimeStamp($encryptClass->decrypt($this->getRequestHeaderData()['X-TimeStamp']));
        $timeDiff = $this->hmacObj->timeStampDiff();
        //print_r('---'.$timeDiff.'---');      
        //print_r('zzz'.$this->getRequestHeaderData()['X-TimeStamp'].'zzz' );
        //print_r('zzz'.$encryptClass->decrypt($this->getRequestHeaderData()['X-TimeStamp']).'zzz' );
        
        if($timeDiff > $this->requestExpireTime)  {
            //print_r ('-----expire time exceeded----');
            $hashNotMatchForwarder = new \Utill\Forwarder\timeExpiredForwarder();
            $hashNotMatchForwarder->redirect();
            
        } else {
           //print_r ('-----expire time not exceeded----'); 
        }  
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