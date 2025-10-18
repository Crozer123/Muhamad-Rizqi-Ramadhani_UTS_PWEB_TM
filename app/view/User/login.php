<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="resource/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <div class="logo">
                <i class="fas fa-user-circle"></i>
            </div>
            <h1>Selamat Datang </h1>
            <p class="subtitle">Silakan login ke akun Anda</p>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="message error">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            
            <?php if(isset($_SESSION['success'])): ?>
                <div class="message success">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?c=user&f=login" method="POST">
                <div class="input-group">
                    <label for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input type="email" id="email" name="email" required placeholder="nama@email.com">
                </div>
                <div class="input-group">
                    <label for="password"><i class="fas fa-lock"></i> Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" required placeholder="Masukkan password">
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
                    </div>
                </div>
                <button type="submit" class="btn"><i class="fas fa-sign-in-alt"></i> Login</button>
            </form>
            
            <p class="toggle-text">Belum punya akun? <a href="index.php?c=user&f=showRegister">Daftar di sini</a></p>
        </div>

        <div class="side-panel">
            <h2>Selamat Datang Kembali!</h2>
            <p>Untuk tetap terhubung dengan kami, silakan login dengan info pribadi Anda</p>
            <a href="index.php?c=user&f=showRegister" class="side-btn"><i class="fas fa-user-plus"></i> Daftar</a>
        </div>
    </div>
    <script src="resource/script.js"></script>
</body>
</html>
