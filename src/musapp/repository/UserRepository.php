<?php

namespace Musapp\Repository;

use Aura\Payload\Payload;
use Aura\Payload_Interface\PayloadStatus;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

use Musapp\Exceptions\EntryNotFoundException;

use Musapp\Model\UserModel;

/**
 * Description of AlbumCrud
 *
 * @author User
 */
class UserRepository 
{
    /**
     * @var Payload
     */
    protected $payload;
    
    protected $model;


    public function __construct() 
    {
        $this->payload = new Payload();
        $this->model = new UserModel();
    }
    

    public function findUser(array $input) {
        try {
            $data = $this->model->getEntry($input['id']);
        } catch(EntryNotFoundException $e) {
            return $this->payload
                ->setStatus(PayloadStatus::NOT_VALID)
                ->setMessages('Entry not found')
                ->setOutput($input);
        } catch (\Exception $e) {
            return $this->payload
                ->setStatus(PayloadStatus::ERROR)
                ->setMessages($e->getMessage())
                ->setOutput($input);
        }
        
        return $this->payload
                ->setStatus(PayloadStatus::SUCCESS)
                ->setOutput($data);
    }
    
    
    public function listUsers(array $input) {
        try {
            $data = $this->model->getAllEntries();
            foreach ($data as $key=>&$val) {
                unset($val['password']);
            }
            
        } catch(\Exception $e) {
            return $this->payload
                ->setStatus(PayloadStatus::NOT_VALID)
                ->setMessages('Entries not found')
                ->setOutput($input);
        }
        
        return $this->payload
                ->setStatus(PayloadStatus::SUCCESS)
                ->setOutput($data);
    }   
    
    
    public function insertUser(array $input) {
        
        try {
            $uuid = Uuid::uuid4()->toString();
        } catch (UnsatisfiedDependencyException $e) {
            return $this->payload
                    ->setStatus(PayloadStatus::FAILURE)
                    ->setMessages("Can't generate Uuid: "+$e->getMessage())
                    ->setInput($input);
        }
        
        $this->model->setPassword($input['password']??null);
        $this->model->setUsername($input['username']??null);
        $this->model->setId($uuid);
        
        $validator = $this->model->validate();
        
        if (!$validator->isValid()) {
            return $this->payload
                ->setStatus(PayloadStatus::NOT_VALID)
                ->setMessages("Input data validation failed")
                ->setOutput($validator->getMessages());
        }
        
        $this->model->save();
        
        return $this->payload
                ->setStatus(PayloadStatus::SUCCESS)
                ->setOutput(['uuid'=>$uuid]);
    }
    
    public function updateUser(array $input) {
        try {
            $data = $this->model->getEntry($input['id']);
        } catch(EntryNotFoundException $e) {
            return $this->payload
                ->setStatus(PayloadStatus::NOT_VALID)
                ->setMessages('Entry not found')
                ->setOutput($input);
        }
        
        $this->model->setId($input['id']);
        $this->model->setPassword($input['password']??null);
        $this->model->setUsername($input['username']??null);
        
        $validator = $this->model->validate();
        
        if (!$validator->isValid()) {
            return $this->payload
                ->setStatus(PayloadStatus::NOT_VALID)
                ->setMessages("Input data validation failed")
                ->setOutput($validator->getMessages());
        }
        
        $this->model->save();
        
        return $this->payload
                ->setStatus(PayloadStatus::SUCCESS)
                ->setOutput($input);
        
    }
    
    public function deleteUser(array $input) {
        try {
            $data = $this->model->getEntry($input['id']);
        } catch(EntryNotFoundException $e) {
            return $this->payload
                ->setStatus(PayloadStatus::NOT_VALID)
                ->setMessages('Entry not found')
                ->setOutput($input);
        }
        
        $this->model->deleteEntry($input['id']);
        
        return $this->payload
                ->setStatus(PayloadStatus::SUCCESS)
                ->setMessages('Entry has been deleted');
        
    }
    
}
