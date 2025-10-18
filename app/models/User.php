<?php
class User {
    public $id;
    public $nama;
    public $email;
    public $password;
    public $created_at;
    public $last_login;

    public function __construct($id = null, $nama = null, $email = null,$password = null,$created_at = null,$last_login = null) {
        $this->id       = $id;
        $this->nama     = $nama;
        $this->email    = $email;
        $this->password = $password;
        $this->created_at = $created_at;
        $this->last_login = $last_login;
    }
}
?>
