<?php

namespace Musapp;

use Musapp\Model\UserModel;

class Authenticator 
{
    /**
     *
     * @var UserModel
     */
    protected $model;
    
    protected $userData = [];
    
    public function getUserData(): array {
        return $this->userData;
    }

    public function __construct() {
        $this->model = new UserModel();
    }


    public function validate(string $username, string $password)
    {
        $found = false;
        $users = $this->model->getAllEntries();
            
        foreach ($users as $user) {
            if ($user['username'] == $username) {
                $found = true;
                break;
            }
        }
            
        unset($users);
            
        if (!$found) {
            throw new Exceptions\UserNotFoundException;
        }
            
        if (!password_verify($password, $user['password'])) {
            throw new Exceptions\UserCredentialsNotMatchException;
        }
        
        unset($user['password']);
        
        $this->userData = $user;
        
        return true;
    }
}
