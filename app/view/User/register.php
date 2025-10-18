<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="public/resource/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Buat Akun Baru</h1>
            <p class="subtitle">Isi form di bawah untuk mendaftar</p>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="message error">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?c=user&f=register" method="POST">
                <div class="input-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" required placeholder="Nama lengkap Anda">
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="nama@email.com">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Minimal 6 karakter">
                </div>
                <div class="input-group">
                    <label for="confirm_password">Konfirmasi Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required placeholder="Ulangi password">
                </div>
                <button type="submit" class="btn">Daftar</button>
            </form>
            
            <p class="toggle-text">Sudah punya akun? <a href="index.php?c=user&f=showLogin">Login di sini</a></p>
        </div>

        <div class="side-panel">
            <h2>Halo, silahkan daftar duluu</h2>
        </div>
    </div>
</body>
</html>