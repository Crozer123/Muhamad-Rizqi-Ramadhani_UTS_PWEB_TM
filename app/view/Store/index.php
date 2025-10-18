<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Rizqi App</title>
    <link rel="stylesheet" href="/resource/store.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <nav class="store-nav">
        <a href="index.php?c=store&f=index" class="logo">
            <i class="fas fa-cube"></i> Rizqi App
        </a>
        <div class="nav-links">
            <?php if(isset($_SESSION['userid'])): ?>
                <span>Halo, <?php echo htmlspecialchars(explode(' ', $_SESSION['nama'])[0]); ?>!</span>
                
                <?php if($_SESSION['role'] == 'admin'): ?>
                    <a href="index.php?c=user&f=dashboard" class="btn-login">Admin Dashboard</a>
                <?php else: ?>
                    <a href="#">Keranjang Saya</a>
                <?php endif; ?>

                <a href="index.php?c=user&f=logout">Logout</a>

            <?php else: ?>
                <a href="index.php?c=user&f=showRegister">Daftar</a>
                <a href="index.php?c=user&f=showLogin" class="btn-login">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="store-container">
        <h1>Produk Kami</h1>

        <div class="product-grid">
            
            <?php foreach ($data['products'] as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    (Gambar Produk)
                </div>
                <div class="product-info">
                    <h2 class="product-name"><?php echo htmlspecialchars($product->name); ?></h2>
                    <p class="product-desc"><?php echo htmlspecialchars($product->description); ?></p>
                    <div class="product-footer">
                        <span class="product-price">Rp <?php echo number_format($product->price, 0, ',', '.'); ?></span>
                        <a href="#" class="btn-buy">
                            <i class="fas fa-shopping-cart"></i> Beli
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <?php if (empty($data['products'])): ?>
                <p>Belum ada produk yang dijual saat ini.</p>
            <?php endif; ?>

        </div>
    </div>

</body>
</html>