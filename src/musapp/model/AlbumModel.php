<?php
declare (strict_types=1);

namespace Musapp\Model;

use Musapp\Model;

/**
 * Description of User
 *
 * @author User
 */
class AlbumModel extends Model 
{
    protected $id;
    protected $name;
    protected $date_released;
    
    public function getFieldValues(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'date_released' => $this->date_released
        ];
    }
    
    public function getFieldValidations(): array {
        return [
            'id' => ['required', 'length'=>36],
            'name' => ['required', 'min-length'=>2, 'max-length'=>32],
            'date_released' => ['required', 'date-format' =>'Y-d-m']
        ];
    }
    
    public function getTableName(): string {
        return "albums";
    }
            
    function getId() {
        return $this->id;
    }

    function getName() {
        return $this->name;
    }

    function getDateReleased() {
        return $this->date_released;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDateReleased($date_released) {
        $this->date_released = $date_released;
    }


    
}
