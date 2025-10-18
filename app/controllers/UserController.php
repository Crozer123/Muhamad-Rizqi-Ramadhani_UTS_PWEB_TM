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
      if ($_SESSION['role'] === 'user') {
            header('Location: index.php?c=store&f=index');
            exit;
        } else if ($_SESSION['role'] !== 'admin') {
            $_SESSION['error'] = 'Anda tidak memiliki hak akses!';
            session_unset();
            session_destroy();
            header('Location: index.php?c=user&f=showLogin');
            exit;
        }

        $totalUsers = $this->userService->countTotalUsers();
        $totalUsers = $this->userService->countTotalUsers();
        $newUsersThisMonth = $this->userService->countNewUsersThisMonth();
        $newUsersLastMonth = $this->userService->countNewUsersLastMonth();
        $userGrowthPercentage = 0;
        if ($newUsersLastMonth > 0) {
            $userGrowthPercentage = (($newUsersThisMonth - $newUsersLastMonth) / $newUsersLastMonth) * 100;
        } else if ($newUsersThisMonth > 0) {
            $userGrowthPercentage = 100; 
        }
        
        $data = [
            'totalUsers' => $totalUsers,
            'newUsersThisMonth' => $newUsersThisMonth,
            'userGrowthPercentage' => round($userGrowthPercentage), // Dibulatkan
        ];

        include __DIR__ . '/../view/User/dashboard.php';
    }
    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Email dan password harus diisi!';
            header('Location: index.php?c=user&f=showLogin');
            exit;
        }

        $user = $this->userService->findByEmail($email);
        
        if ($user && password_verify($password, $user->password)) {
            $this->userService->updateLastLogin($user->id);
            $_SESSION['userid'] = $user->id;
            $_SESSION['nama'] = $user->nama;
            $_SESSION['email'] = $user->email;
            $_SESSION['role'] = $user->role;
            $_SESSION['created_at'] = $user->created_at; 
            $_SESSION['last_login'] = date('Y-m-d H:i:s'); 
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

    public function changePassword() {
    header('Content-Type: application/json');
    error_log('ChangePassword called'); 
    if (!isset($_SESSION['userid'])) {
        echo json_encode(['success' => false, 'message' => 'User tidak login']);
        return;
    }

    $userId = $_SESSION['userid'];
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmNewPassword = $_POST['confirm_new_password'] ?? '';

    error_log("UserID: $userId, Current: $currentPassword, New: $newPassword"); 

    if (empty($currentPassword) || empty($newPassword) || empty($confirmNewPassword)) {
        echo json_encode(['success' => false, 'message' => 'Semua field password harus diisi!']);
        return;
    }

    if ($newPassword !== $confirmNewPassword) {
        echo json_encode(['success' => false, 'message' => 'Password baru dan konfirmasi tidak cocok!']);
        return;
    }

    if (strlen($newPassword) < 6) {
        echo json_encode(['success' => false, 'message' => 'Password minimal 6 karakter!']);
        return;
    }

    $success = $this->userService->updatePassword($userId, $currentPassword, $newPassword);
    error_log("Update success: " . ($success ? 'true' : 'false')); // Log hasil

    if ($success) {
        echo json_encode(['success' => true, 'message' => 'Password berhasil diperbarui!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Gagal memperbarui password. Pastikan password saat ini benar.']);
    }
}
public function updateProfile() {
        header('Content-Type: application/json');
        if (!isset($_SESSION['userid'])) {
            echo json_encode(['success' => false, 'message' => 'User tidak login']);
            return;
        }
        $userId = $_SESSION['userid'];
        $nama = $_POST['nama'] ?? '';
        $email = $_POST['email'] ?? '';
        if (empty($nama) || empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Nama dan Email harus diisi!']);
            return;
        }
        $success = $this->userService->updateProfile($userId, $nama, $email);
        
        if ($success) {
            $_SESSION['nama'] = $nama;
            $_SESSION['email'] = $email;
            $_SESSION['success'] = 'Profil berhasil diperbarui!';
            
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal memperbarui profil. Email mungkin sudah digunakan oleh akun lain.']);
        }
    }
}
?>
