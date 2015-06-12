<?php

namespace Slim;

use Slim\Slim;



class SlimExtended extends Slim {
    
    /**
     * exceptions and rabbitMQ configuration parameters
     * @author Mustafa Zeynel Dağlı
     */
    const EXCEPTIONS_RABBITMQ_DATABASE = 'database';
    const EXCEPTIONS_RABBITMQ_FILE = 'file';
    
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
     * default settings extended for rabbitMQ and exceptions managing configuration
     * Get default application settings
     * @return array
     * @author Mustafa Zeynel Dağlı
     */
    public static function getDefaultSettings()
    {
        return array(
            // Application
            'mode' => 'development',
            // Debugging
            'debug' => true,
            // Logging
            'log.writer' => null,
            'log.level' => \Slim\Log::DEBUG,
            'log.enabled' => true,
            // View
            'templates.path' => './templates',
            'view' => '\Slim\View',
            // Cookies
            'cookies.encrypt' => false,
            'cookies.lifetime' => '20 minutes',
            'cookies.path' => '/',
            'cookies.domain' => null,
            'cookies.secure' => false,
            'cookies.httponly' => false,
            // Encryption
            'cookies.secret_key' => 'CHANGE_ME',
            'cookies.cipher' => MCRYPT_RIJNDAEL_256,
            'cookies.cipher_mode' => MCRYPT_MODE_CBC,
            // HTTP
            'http.version' => '1.1',
            // Routing
            'routes.case_sensitive' => true,
            //Exceptions / rabbitMQ management
            'exceptions.rabbitMQ' => true,
            'exceptions.rabbitMQ.logging' => self::EXCEPTIONS_RABBITMQ_FILE
        );
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

