<?php
require_once __DIR__ . '/../service/UserService.php';

class UserController {
    private $userService;

    public function __construct() {
        $this->userService = new UserService();
    }

    public function showLogin() {

        if (isset($_SESSION['userid'])) {
            header('Location: index.php?c=user&f=dashboard');
            exit;
        }
        include __DIR__ . '/../view/User/login.php';
    }

    public function showRegister() {
        if (isset($_SESSION['userid'])) {
            header('Location: index.php?c=user&f=dashboard');
            exit;
        }
        include __DIR__ . '/../view/User/register.php';
    }

    public function dashboard() {
        if (!isset($_SESSION['userid'])) {
            $_SESSION['error'] = 'Silakan login terlebih dahulu!';
            header('Location: index.php?c=user&f=showLogin');
            exit;
        }
        include __DIR__ . '/../view/User/dashboard.php';
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Validasi input
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Email dan password harus diisi!';
            header('Location: index.php?c=user&f=showLogin');
            exit;
        }

        $user = $this->userService->findByEmail($email);
        
        if ($user && password_verify($password, $user->password)) {
            $_SESSION['userid'] = $user->id;
            $_SESSION['nama'] = $user->nama;
            $_SESSION['email'] = $user->email;
            $_SESSION['success'] = 'Login berhasil! Selamat datang, ' . $user->nama;
            header('Location: index.php?c=user&f=dashboard');
            exit;
        } else {
            $_SESSION['error'] = 'Email atau password salah!';
            header('Location: index.php?c=user&f=showLogin');
            exit;
        }
    }

    public function register() {
        $nama = $_POST['nama'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmpassword = $_POST['confirm_password'] ?? '';

        // Validasi
        if (empty($nama) || empty($email) || empty($password) || empty($confirmpassword)) {
            $_SESSION['error'] = 'Semua field harus diisi!';
            header('Location: index.php?c=user&f=showRegister');
            exit;
        }

        if ($password !== $confirmpassword) {
            $_SESSION['error'] = 'Password dan konfirmasi tidak cocok!';
            header('Location: index.php?c=user&f=showRegister');
            exit;
        }

        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Password minimal 6 karakter!';
            header('Location: index.php?c=user&f=showRegister');
            exit;
        }

        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $success = $this->userService->create($nama, $email, $hashed);
        
        if ($success) {
            $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
            header('Location: index.php?c=user&f=showLogin');
            exit;
        } else {
            $_SESSION['error'] = 'Registrasi gagal! Email mungkin sudah terdaftar.';
            header('Location: index.php?c=user&f=showRegister');
            exit;
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?c=user&f=showLogin');
        exit;
    }
}