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
  class MiddlewareTest extends \Slim\Middleware implements \ArrayAccess, \IteratorAggregate, \Countable
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
     * Constructor
     * @param  array  $settings
     */
    public function __construct($settings = array())
    {
        
        
    }

    /**
     * Call
     */
    public function call()
    {
        print_r('MiddlewareTest middleware call method------');
        //print_r($this->next);
        //Read flash messaging from previous request if available
        //$this->loadMessages();

        //Prepare flash messaging for current request
        //$env = $this->app->environment();
        //$env['slim.flash'] = $this;
        
        
        
        // Create a validator chain and add validators to it
        $validatorChain = new \Zend\Validator\ValidatorChain();
        $validatorChain->attach(
                            new \Zend\Validator\StringLength(array('min' => 6,
                                                                 'max' => 12)))
                       ->attach(new \Zend\I18n\Validator\Alnum());

        // Validate the username
        if ($validatorChain->isValid("testteeewwwwwwwwwwwww__")) {
            // username passed validation
        } else {
            // username failed validation; print reasons
            foreach ($validatorChain->getMessages() as $message) {
                echo "$message\n";
            }
            //$this->app->redirect('/error');
            //$this->app->error();
            //$this->app->halt(500, "info status test!!!!");
            /*$this->app->contentType('application/json');
            $this->app->halt(500, '{"error":"Something went wrong"}');
            $this->app->stop();*/
            //exit();
            //$this->app->run();
            
            /*$response = $this->app->response();

            //Generate Response headers
            $response->header('Content-Type', "application/json");
            $response->status(DEFAULT_RESPONSE_CODE);                  
            $response->header('Content-Length', '500');

            $responseBody = array('message'=> $message);
            $response->body(json_encode($responseBody));


            $response->send();*/
            
         //ob_clean();
            
            $publicHash = '3441df0babc2a2dda551d7cd39fb235bc4e09cd1e4556bf261bb49188f548348';
            $privateHash = 'e249c439ed7697df2a4b045d97d4b9b7e1854c3ff8dd668c779013653913572e';
            $content    = json_encode(array(
                'test' => 'content'
            ));
            
            $this->app->setPublicHash('3441df0babc2a2dda551d7cd39fb235bc4e09cd1e4556bf261bb49188f548348');
            
            print_r("------public hash---------".$this->app->getPublicHash()."------public hash---------");

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
         
            
        }
        
        
        $validator = new \Zend\Validator\Barcode('EAN13');
        
        $floatValidator = new \Zend\I18n\Validator\IsFloat();
        if($floatValidator->isValid(5.3)) print_r ("--float test edildi onaylandÄ±---");
        
        $intValidator = new \Zend\I18n\Validator\IsInt();
        $intValidator->setMessage("test validation");
        
        if($intValidator->isValid(5)) print_r ("--int test edildi onaylandÄ±---");
        
        $validator = new \Zend\Validator\StringLength();
        $validator->setMax(6);
        
        $validator->isValid("Test"); // returns true
        $validator->isValid("Testing"); // returns false
        
        print_r($validator->isValid("Test"));
        print_r("fffffffffffffffffffff----    ");
        print_r($validator->isValid("Testing"));
        if(!$validator->isValid("Testing")) print_r("---is not valid----");
        
        $logger = new \Zend\Log\Logger;
        $writer = new \Zend\Log\Writer\Stream('php://output');

        $logger->addWriter($writer);
        $logger->log(\Zend\Log\Logger::INFO, 'Informational message');
        print_r($this->app->request->params());
        $this->app->log->debug("test loggg");
        $this->next->call();
        //$this->save();
    }

    public function count($mode = 'COUNT_NORMAL') {
        
    }

    public function getIterator() {
        
    }

    public function offsetExists($offset) {
        
    }

    public function offsetGet($offset) {
        
    }

    public function offsetSet($offset,
            $value) {
        
    }

    public function offsetUnset($offset) {
        
    }

}