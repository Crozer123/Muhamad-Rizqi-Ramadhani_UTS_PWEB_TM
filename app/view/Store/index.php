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
                    <a href="index.php?c=cart&f=viewCart">Keranjang Saya</a> 
                <?php endif; ?>

                <a href="index.php?c=user&f=logout">Logout</a>

            <?php else: ?>
                <a href="index.php?c=user&f=showRegister">Daftar</a>
                <a href="index.php?c=user&f=showLogin" class="btn-login">Login</a>
            <?php endif; ?>
        </div>
    </nav>

    <div style="max-width: 1200px; margin: 1rem auto; padding: 0 1rem;">
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success" style="background-color: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; font-weight: 500;">
                <i class="fas fa-check-circle" style="margin-right: 0.5rem;"></i>
                <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>
        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger" style="background-color: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; font-weight: 500;">
                 <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i>
                <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="store-container">
        <h1>Produk Kami</h1>

        <div class="product-grid">
            
            <?php foreach ($data['products'] as $product): ?>
            <div class="product-card">
                
                <div class="product-image">
                     <?php if ($product->image_url): ?>
                        <img src="<?php echo htmlspecialchars($product->image_url); ?>" 
                             alt="<?php echo htmlspecialchars($product->name); ?>" 
                             style="width: 100%; height: 100%; object-fit: cover;">
                    <?php else: ?>
                       <span style="display: flex; align-items: center; justify-content: center; height: 100%; color: #aaa;">(Gambar Produk)</span>
                    <?php endif; ?>
                </div>

                <div class="product-info">
                    <h2 class="product-name"><?php echo htmlspecialchars($product->name); ?></h2>
                    <p class="product-desc"><?php echo htmlspecialchars($product->description); ?></p>
                    <div class="product-footer">
                        <span class="product-price">Rp <?php echo number_format($product->price, 0, ',', '.'); ?></span>
                        <a href="index.php?c=cart&f=add&id=<?php echo $product->id; ?>" class="btn-buy">
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