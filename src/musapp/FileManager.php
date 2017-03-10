<?php

namespace Musapp;

/**
 * Description of FileManager
 *
 * @author User
 */
class FileManager {
    
    protected $workingDirectory = "";
    protected $defaultFileExtension = "";
    
    function getDefaultFileExtension() {
        return trim($this->defaultFileExtension,'.');
    }

    function setDefaultFileExtension(string $defaultFileExtension) {
        $this->defaultFileExtension = '.'.$defaultFileExtension;
    }

    function getWorkingDirectory(): string {
        return $this->workingDirectory;
    }

    function setWorkingDirectory(string $workingDirectory) {
        $this->workingDirectory = $workingDirectory;
    }

    public function readFile(string $path) {
        return @file_get_contents($this->getFullFilePath($path));
    }
    
    
    public function writeFile(string $fileName, string $contents){
        @file_put_contents($this->getFullFilePath($fileName), $contents);
    }
    public function deleteFile(string $fileName){
        unlink($this->getFullFilePath($fileName));
    }

    public function listDirectory(string $dir) {
        $path = $this->workingDirectory.'/'.$dir;
        $fileList = array_diff(scandir($path), array('..', '.'));
        return $fileList;
    }
    
    protected function getFullFilePath(string $fileName): string {
        return $this->workingDirectory.'/'
                .$fileName
                .$this->defaultFileExtension;
    }
}
