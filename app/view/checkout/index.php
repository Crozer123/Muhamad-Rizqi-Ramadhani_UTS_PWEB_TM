<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Checkout - Rizqi App</title>
    <link rel="stylesheet" href="/public/resource/store.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <style>
        .checkout-summary { background-color: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .checkout-item { display: flex; justify-content: space-between; padding: 0.8rem 0; border-bottom: 1px solid #e2e8f0; }
        .checkout-item:last-child { border-bottom: none; }
        .checkout-item span:first-child { color: #475569; }
        .checkout-total { font-size: 1.3rem; font-weight: bold; margin-top: 1.5rem; padding-top: 1rem; border-top: 2px solid #1e293b; }
        .checkout-actions { margin-top: 2rem; text-align: right; }
        .btn-confirm { background-color: #10b981; color: #fff; padding: 0.8rem 1.5rem; text-decoration: none; border-radius: 8px; font-weight: 600; border: none; cursor: pointer; }
         .btn-cancel { margin-left: 1rem; color: #64748b; text-decoration: none;}
    </style>
</head>
<body>

    <nav class="store-nav">
        <a href="index.php?c=store&f=index" class="logo"><i class="fas fa-cube"></i> Rizqi App</a>
        <div class="nav-links">
             <?php if(isset($_SESSION['userid'])): ?>
                <span>Halo, <?php echo htmlspecialchars(explode(' ', $_SESSION['nama'])[0]); ?>!</span>
                 <?php if($_SESSION['role'] == 'admin'): ?>
                    <a href="index.php?c=user&f=dashboard" class="btn-login">Admin Dashboard</a>
                <?php else: ?>
                    <a href="index.php?c=cart&f=viewCart">Keranjang Saya</a> 
                <?php endif; ?>
                <a href="index.php?c=user&f=logout">Logout</a>
            <?php endif; ?>
        </div>
    </nav>
    
    <div class="store-container">
        <h1>Konfirmasi Pesanan Anda</h1>

        <div class="checkout-summary">
            <h2>Ringkasan Belanja</h2>
            <?php 
                $total_price = 0; 
                foreach ($data['cart_items'] as $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total_price += $subtotal;
            ?>
                <div class="checkout-item">
                    <span><?php echo htmlspecialchars($item['name']); ?> (x<?php echo $item['quantity']; ?>)</span>
                    <span>Rp <?php echo number_format($subtotal, 0, ',', '.'); ?></span>
                </div>
            <?php endforeach; ?>

            <div class="checkout-total">
                <span>Total Pembayaran</span>
                <span>Rp <?php echo number_format($total_price, 0, ',', '.'); ?></span>
            </div>

             <div class="checkout-actions">
                 <form action="index.php?c=checkout&f=process" method="POST" style="display:inline;">
                    <button type="submit" class="btn-confirm">
                        <i class="fas fa-check"></i> Konfirmasi & Bayar Sekarang
                    </button>
                 </form>
                <a href="index.php?c=cart&f=viewCart" class="btn-cancel">Kembali ke Keranjang</a>
            </div>
             <p style="margin-top: 1.5rem; font-size: 0.9rem; color: #64748b;">*Ini adalah simulasi. Klik "Konfirmasi" untuk menyelesaikan pesanan.</p>
        </div>
    </div>

</body>
</html>