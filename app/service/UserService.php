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
   
        $stmt = $this->conn->prepare('SELECT id_akun, nama, email, password,role, created_at, last_login FROM akun WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();  
        $row = $result->fetch_assoc();
        $stmt->close();
        if ($row) {
            $user = new User($row['id_akun'], $row['nama'], $row['email'], $row['password']);
            $user->role = $row['role'];
            $user->created_at = $row['created_at'];
            $user->last_login = $row['last_login'];
            return $user;
        }
        return null;
    }

    public function create($nama, $email, $password) {
        $existingUser = $this->findByEmail($email);
        if ($existingUser) {
            return false; 
        }
        $stmt = $this->conn->prepare('INSERT INTO akun (nama, email, password,role) VALUES (?, ?, ?,"user")');
        $stmt->bind_param('sss', $nama, $email, $password);
        return $stmt->execute();
    }

    public function countTotalUsers() {
        $result = $this->conn->query('SELECT COUNT(id_akun) as total FROM akun');
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    public function countActiveSessions() {
        $result = $this->conn->query("SELECT COUNT(id_akun) as total FROM akun WHERE last_login >= NOW() - INTERVAL 1 DAY");
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    
    public function updateLastLogin($userId) {
        $stmt = $this->conn->prepare('UPDATE akun SET last_login = NOW() WHERE id_akun = ?');
        $stmt->bind_param('i', $userId);
        return $stmt->execute();
    }
    
    public function getNewUsersThisMonth() {
        $result = $this->conn->query("SELECT COUNT(id_akun) as total FROM akun WHERE MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())");
        $row = $result->fetch_assoc();
        return $row['total'];
    }
    public function updatePassword($userId, $currentPassword, $newPassword) {
        $stmt = $this->conn->prepare('SELECT password FROM akun WHERE id_akun = ?');
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            return false;
        }

        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare('UPDATE akun SET password = ? WHERE id_akun = ?');
        $stmt->bind_param('si', $hashedNewPassword, $userId);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    public function updateProfile($userId, $nama, $email) {
        $stmt = $this->conn->prepare('SELECT id_akun FROM akun WHERE email = ? AND id_akun != ?');
        $stmt->bind_param('si', $email, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $stmt->close();
            return false; 
        }
        $stmt->close();
        $updateStmt = $this->conn->prepare('UPDATE akun SET nama = ?, email = ? WHERE id_akun = ?');
        $updateStmt->bind_param('ssi', $nama, $email, $userId);
        $success = $updateStmt->execute();
        $updateStmt->close();
        
        return $success; 
    }

    public function countNewUsersThisMonth() {
        $query = "SELECT COUNT(id_akun) as total FROM akun WHERE MONTH(created_at) = MONTH(CURRENT_DATE) AND YEAR(created_at) = YEAR(CURRENT_DATE)";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    public function countNewUsersLastMonth() {
        $query = "SELECT COUNT(id_akun) as total FROM akun WHERE MONTH(created_at) = MONTH(CURRENT_DATE - INTERVAL 1 MONTH) AND YEAR(created_at) = YEAR(CURRENT_DATE - INTERVAL 1 MONTH)";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    

 

}
?>
