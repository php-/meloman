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
class AuthRepository 
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
    
    
    public function authUser(array $input){
        
        if (!isset($input['username'], $input['password'])) {
            return $this->payload
                ->setStatus(PayloadStatus::NOT_VALID)
                ->setMessages('Please provide username and password field');
        }
        
        try {
            
            $this->authenticator->validate($input['username'], $input['password']);
            
        } catch (UserNotFoundException $e)  {
          
                return $this->payload
                    ->setStatus(PayloadStatus::NOT_VALID)
                    ->setMessages('User not found');
                
        } catch (UserCredentialsNotMatchException $e) {
            
                return $this->payload
                    ->setStatus(PayloadStatus::NOT_VALID)
                    ->setMessages('User credentials does not match');
        }
            
        return $this->payload
                ->setStatus(PayloadStatus::SUCCESS)
                ->setOutput($this->authenticator->getUserData());
    }

    
}
