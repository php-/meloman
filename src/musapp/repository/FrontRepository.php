<?php

namespace Musapp\Repository;

use Aura\Payload\Payload;
use Aura\Payload_Interface\PayloadStatus;

use Musapp\Authenticator;

use Musapp\Exceptions\UserNotFoundException;
use Musapp\Exceptions\UserCredentialsNotMatchException;


/**
 * Description of AlbumCrud
 *
 * @author User
 */
class FrontRepository 
{
    /**
     * @var Payload
     */
    protected $payload;
    
    /**
     * @var Authenticator
     */
    protected $authenticator;

    public function __construct() 
    {
        $this->payload = new Payload();
        $this->authenticator = new Authenticator();
    }
    
    public function welcome(array $input){
        return $this->payload
            ->setStatus(PayloadStatus::SUCCESS)
            ->setMessages(['Welcome to API'])
            ->setOutput(["Hello"=>"World!"]);
    }

}
