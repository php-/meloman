<?php

namespace Musapp;

/**
 * Description of Model
 *
 * @author User
 */
abstract class Model {
    
    /**
     *
     * @var JsonDataProvider
     */
    protected $dataProvider;
    
    public function __construct() {
        $this->dataProvider = new JsonDataProvider();
    }
    
    public abstract function getFieldValues(): array;
    public abstract function getFieldValidations(): array;
    public abstract function getTableName(): string;
    public function getKey(): string {
        return $this->id ?? '';
    }
    
    /**
     * 
     * @return Validator
     */
    public function validate() {
        return Validator::getValidator($this->getFieldValidations(), $this->getFieldValues());
    }
    
    
    public function save() {
        $this->dataProvider->writeData(
                $this->getDataPath(), 
                $this->getFieldValues());
    }
    
    public function getEntry(string $id): array {
        return $this->dataProvider->readData($this->getTableName().'/'.$id);
    }
    
    
    public function getAllEntries(){
        $ids = $this->dataProvider->listEntries($this->getTableName());
        
        return $ids;
    }

    public function getDataPath(): string {
        return $this->getTableName().'/'.$this->getKey();
    }
    
    public function deleteEntry(string $id) {
        $this->dataProvider->deleteData($this->getTableName().'/'.$id);
    }
    
}
