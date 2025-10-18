<?php
require_once __DIR__ . '/../models/User.php';

class UserService {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'mvc_db');
        if ($this->conn->connect_error) {
            die('Koneksi database gagal: ' . $this->conn->connect_error);
        }
    }

    public function findByEmail($email) {
        $stmt = $this->conn->prepare('SELECT * FROM akun WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        if ($row) {
            return new User($row['id_akun'], $row['nama'], $row['email'], $row['password']);
        }
        return null;
    }

    public function create($nama, $email, $password) {
        $existingUser = $this->findByEmail($email);
        if ($existingUser) {
            return false; 
        }
        $stmt = $this->conn->prepare('INSERT INTO akun (nama, email, password) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $nama, $email, $password);
        return $stmt->execute();
    }
}
?>