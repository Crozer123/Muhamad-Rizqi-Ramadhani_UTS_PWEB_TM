<?php
class User {
    public $id;
    public $nama;
    public $email;
    public $password;

    public function __construct($id = null, $nama = null, $email = null,$password = null) {
        $this->id       = $id;
        $this->nama     = $nama;
        $this->email    = $email;
        $this->password = $password;
    }
}
?>
