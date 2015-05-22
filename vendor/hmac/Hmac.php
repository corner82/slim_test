<?php
/**
 * Rest Api Proxy Library
 *
 * @author Zeynel Dağlı
 * @version 0.2
 */
namespace Hmac;

class Hmac {
    
    protected $hash;
    
    protected $publicKey;
    
    protected $privateKey;
    
    protected $requestParams = array();
    
    protected $nonce = null;
    
    protected $timeStamp = null;

    public function __construct() {
        
    }
    
    public function setHash($hash = null) {
        $this->hash = $hash;
    }
    
    public function getHash() {
        return $this->hash;
    }
    
    public function setNonce($nonce = null) {
        if($nonce == null) {
            $this->nonce = md5(time().rand());
        } else {
            $this->nonce = $nonce;
        }        
        //print_r('!!!!'.$this->nonce.'!!!!');
    }
    
    public function getNonce() {
        //if($this->nonce==null) $this->setNonce();
        //print_r('// get nonce()--'.$this->nonce.'//');
        return $this->nonce;
    }
    
     /**
     * set timestamp 
     * framework
     * @param string $timeStamp
     * @author Okan Cıran
     * @version 0.0.1
     */
      public function setTimeStamp($timeStamp = null) {
        if($timeStamp == null) {
            $this->timeStamp = time();
         } else {
            $this->timeStamp = $timeStamp;
        }   
    }
    
     /**
     * get timestamp 
     * framework
     * 
     * @author Okan Cıran
     * @version 0.0.1
     */
    public function getTimeStamp() {
        return $this->timeStamp;
    }   
    
     /**
     * difference timestamp 
     * framework
     * @param string $timeStamp
     * @author Okan Cıran
     * @version 0.0.1
     */
      public function differenceTimeStamp() {
        if($this->getTimeStamp() != null) {
            return time() - $this->getTimeStamp();
         } else {
            return null;
        } 
         print_r('// differenceTimeStamp()--'.$this->differenceTimeStamp().'//');
    } 
       
    public function makeHmac() {
        $this->hash = hash_hmac('sha256', hash_hmac('sha256', json_encode($this->requestParams),  $this->getNonce()), $this->privateKey);
        //print_r('++'.$this->hash.'++');
        //$this->hash = hash_hmac('sha256', json_encode($this->requestParams), $this->privateKey);
    }
    
    public function setPublicKey($publicKey = null) {
        $this->publicKey = $publicKey;
    } 
    
    public function getPublicKey() {
        return $this->publicKey;
    }
    
    public function setPrivateKey($privateKey = null) {
        $this->privateKey = $privateKey;
    }
    
    public function getPrivateKey() {
        return $this->privateKey;
    }
    
    public function setRequestParams($requestParams = null) {
        $this->requestParams = $requestParams;
    }
    
    public function getRequestParams() {
        return $this->requestParams;
    }
}
