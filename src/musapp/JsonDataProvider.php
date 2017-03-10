<?php


namespace Musapp;

use Musapp\FileManager;

/**
 * Description of DataProvider
 *
 * @author User
 */
class JsonDataProvider implements DataProviderInterface {
    
    /**
     * @var FileManager
     */
    protected $fileHandler;

    public function __construct() {
        $this->fileHandler = new FileManager();
        $this->fileHandler->setWorkingDirectory($_ENV['ROOT_PATH'].$_ENV['JSON_DATA_PATH']);
        $this->fileHandler->setDefaultFileExtension('json');
    }

    public function readData(string $fileName): array {
        $data = json_decode($this->fileHandler->readFile($fileName), true);
        if (!$data) {
            throw new Exceptions\EntryNotFoundException();
        }
        
        return $data;
    }
    
    public function writeData(string $key, array $data) {
        
        $data = json_encode($data);
        
        $this->fileHandler->writeFile($key, $data);
    }
    
    public function deleteData(string $key) {
        $this->fileHandler->deleteFile($key);
    }
    
    public function listEntries(string $key) {
        $files = $this->fileHandler->listDirectory($key);
        $entries = [];
        
        foreach ($files as $file) {
           $entries[] = $this->readData($key.'/'.substr($file,0,-5));
        }
        
        return $entries;
    }
    
}
