<?php

namespace Slim;

use Slim\Slim;



class SlimExtended extends Slim {
    
    /**
    * @var string
    */
    protected $publicHash;
    
    /**
    * @var string
    */
    protected $privateHash;
    
    /**
    * @var string
    */
    protected $securityContent;
    
    /**
     * encrypt class obj
     * @var \Encrypt\AbstractEncrypt
     * @author Mustafa Zeynel Dağlı
     */
    protected $encryptClass;
    
    /**
     * encrypt class key
     * @var string
     * @author Mustafa Zeynel Dağlı
     */
    protected $encryptKey = 'testKey';

    public function __construct(array $userSettings = array()) {
        parent::__construct($userSettings);
    }
    
    /**
     * set encrytion class obj
     * @param \Encrypt\EncryptManual $encryptClass
     * @author Mustafa Zeynel Dağlı
     */
    public function setEncryptClass(\Encrypt\EncryptManual $encryptClass = null) {
        try {
            if($encryptClass == null) {
                $this->encryptClass = new \Encrypt\EncryptManual($this->encryptKey);
            } else {
                $this->encryptClass = $encryptClass;
            }
            return $this->encryptClass;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }
    
    /**
     * get encrytion class obj
     * @return \Encrypt\EncryptManual
     * @author Mustafa Zeynel Dağlı
     */
    public function getEncryptClass() {
        if($this->encryptClass == null){
            $this->setEncryptClass();
        }else {
            return $this->encryptClass;
        }
    }
    
    
    /**
     * get HMAC security public hash
     * @author Mustafa Zeynel Dağlı
     * @since version 2.6.1
     * @return string
     */
    public function getPublicHash() {
        return $this->publicHash;
    }
    
    /**
     * set HMAC security public hash
     * @author Mustafa Zeynel Dağlı
     * @since version 2.6.1
     * @param type $publicHash
     */
    public function setPublicHash($publicHash) {
         $this->publicHash = $publicHash;
    }
    
    /**
     * get HMAC security public hash
     * @author Mustafa Zeynel Dağlı
     * @since version 2.6.1
     * @return string
     */
    public function getPrivateHash() {
        return $this->privateHash;
    }
    
    /**
     * set HMAC security private hash
     * @author Mustafa Zeynel Dağlı
     * @since version 2.6.1
     * @param type $privateHash
     */
    public function setPrivateHash($privateHash) {
         $this->privateHash = $privateHash;
    }
    
    /**
     * get HMAC security request content hash
     * @author Mustafa Zeynel Dağlı
     * @since version 2.6.1
     * @return string
     */
    public function getSecurityContent() {
        return $this->privateHash;
    }
    
    /**
     * set HMAC security request content hash
     * @author Mustafa Zeynel Dağlı
     * @since version 2.6.1
     * @param type $securityContent
     */
    public function setSecurityContent($securityContent) {
         $this->privateHash = $securityContent;
    }
}

