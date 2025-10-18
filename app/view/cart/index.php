<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Rizqi App</title>
    <link rel="stylesheet" href="/resource/store.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .cart-table { width: 100%; border-collapse: collapse; margin-bottom: 1.5rem; }
        .cart-table th, .cart-table td { padding: 1rem; text-align: left; border-bottom: 1px solid #e2e8f0; }
        .cart-table th { background-color: #f8fafc; font-weight: 600; color: #475569; }
        .cart-table img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; margin-right: 1rem; vertical-align: middle; }
        .cart-table .product-name-cart { font-weight: 600; color: #1e293b; }
        .cart-table .quantity-input { width: 60px; padding: 0.5rem; border: 1px solid #cbd5e1; border-radius: 6px; text-align: center; margin-right: 0.5rem;}
        .cart-table .update-btn { background: none; border: none; color: #3b82f6; cursor: pointer; font-size: 1.2rem; }
        .cart-table .remove-btn { color: #ef4444; text-decoration: none; font-size: 1rem; }
        .cart-summary { text-align: right; margin-top: 1.5rem; }
        .cart-summary h2 { font-size: 1.5rem; margin-bottom: 1rem; }
        .cart-summary .btn-checkout { background-color: #10b981; color: #fff; padding: 0.8rem 1.5rem; text-decoration: none; border-radius: 8px; font-weight: 600; }
        .empty-cart { text-align: center; padding: 2rem; color: #64748b; }
    </style>
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
                    <a href="index.php?c=cart&f=viewCart" style="font-weight: bold; color: #fff;">Keranjang Saya</a> 
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
        <h1>Keranjang Belanja Anda</h1>

        <?php if (!empty($data['cart_items'])): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th colspan="2">Produk</th>
                        <th>Harga</th>
                        <th>Kuantitas</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $total_price = 0; 
                        foreach ($data['cart_items'] as $item): 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total_price += $subtotal;
                    ?>
                    <tr>
                        <td style="width: 80px;">
                             <?php if ($item['image_url']): ?>
                                <img src="<?php echo htmlspecialchars($item['image_url']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            <?php else: ?>
                                <div style="width: 60px; height: 60px; background-color: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 0.8rem;">No-img</div>
                            <?php endif; ?>
                        </td>
                        <td><span class="product-name-cart"><?php echo htmlspecialchars($item['name']); ?></span></td>
                        <td>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                        <td>
                            <form action="index.php?c=cart&f=updateQuantity" method="POST" style="display: inline-flex; align-items: center;">
                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input">
                                <button type="submit" class="update-btn"><i class="fas fa-sync-alt"></i></button>
                            </form>
                        </td>
                        <td>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                        <td>
                            <a href="index.php?c=cart&f=remove&id=<?php echo $item['id']; ?>" class="remove-btn" onclick="return confirm('Hapus item ini dari keranjang?');">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <h2>Total Belanja: Rp <?php echo number_format($total_price, 0, ',', '.'); ?></h2>
              <a href="index.php?c=checkout&f=index" class="btn-checkout"><i class="fas fa-check"></i> Lanjutkan ke Pembayaran</a>
                 <a href="index.php?c=store&f=index" style="margin-left: 1rem; color: #3b82f6;">Kembali Belanja</a>
            </div>

        <?php else: ?>
            <div class="empty-cart">
                <i class="fas fa-shopping-cart fa-3x" style="margin-bottom: 1rem;"></i>
                <p>Keranjang belanja Anda masih kosong.</p>
                <a href="index.php?c=store&f=index" style="margin-top: 1rem; display: inline-block; color: #3b82f6; font-weight: 600;">Mulai Belanja</a>
            </div>
        <?php endif; ?>

    </div>

</body>
</html>