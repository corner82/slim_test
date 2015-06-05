<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Slim\Middleware;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;
 
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
        
        
        $connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
         
        $channel->queue_declare(
            'invoice_queue',    #queue - Queue names may be up to 255 bytes of UTF-8 characters
            false,              #passive - can use this to check whether an exchange exists without modifying the server state
            true,               #durable, make sure that RabbitMQ will never lose our queue if a crash occurs - the queue will survive a broker restart
            false,              #exclusive - used by only one connection and the queue will be deleted when that connection closes
            false               #auto delete - queue is deleted when last consumer unsubscribes
            );
             
        $msg = new AMQPMessage(
            1,
            array('delivery_mode' => 2) # make message persistent, so it is not lost if server crashes or quits
            );
             
        $channel->basic_publish(
            $msg,               #message 
            '',                 #exchange
            'invoice_queue'     #routing key (queue)
            );
             
        $channel->close();
        $connection->close();
        
        
        
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