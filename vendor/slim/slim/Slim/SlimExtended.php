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

    public function __construct(array $userSettings = array()) {
        parent::__construct($userSettings);
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

