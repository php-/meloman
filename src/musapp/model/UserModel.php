<?php
declare (strict_types=1);

namespace Musapp\Model;

use Musapp\Model;

/**
 * Description of User
 *
 * @author User
 */
class UserModel extends Model 
{
    protected $id;
    protected $username;
    protected $password;
    
    public function getFieldValues(): array {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password
        ];
    }
    
    public function getFieldValidations(): array {
        return [
            'id' => ['required', 'length'=>36],
            'username' => ['required', 'email', 'min-length'=>8, 'max-length'=>254],
            'password' => ['required', 'min-length'=>8, 'max-length'=>32]
        ];
    }
    
    public function getTableName(): string {
        return "users";
    }
    
    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    public function save() {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        parent::save();
    }

    public function getEntry(string $id): array {
        $data = parent::getEntry($id);
        if($data) {
            unset($data['password']);
        }
        return $data;
    }
    
}
