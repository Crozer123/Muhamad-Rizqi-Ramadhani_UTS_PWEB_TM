<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - Rizqi App</title>
    <link rel="stylesheet" href="/public/resource/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-cube"></i> Rizqi App</h2>
            </div>
            <nav class="sidebar-nav">
                <a href="index.php?c=user&f=dashboard" class="nav-item">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="index.php?c=product&f=showList" class="nav-item active">
                    <i class="fas fa-box-open"></i>
                    <span>Manajemen Produk</span>
                </a>
                <a href="index.php?c=user&f=logout" class="nav-item logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </nav>
        </aside>

        <main class="main-content">
            <header class="header">
                <div class="header-left">
                    <h1>Manajemen Produk</h1>
                    <p class="breadcrumb"><i class="fas fa-home"></i> Home / Produk</p>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <div class="user-details">
                            <span class="user-name"><?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                            <span class="user-role"><?php echo htmlspecialchars(ucfirst($_SESSION['role'])); ?></span>
                        </div>
                        <div class="user-avatar">
                            <?php echo strtoupper(substr($_SESSION['nama'], 0, 1)); ?>
                        </div>
                    </div>
                </div>
            </header>
            
            <?php if(isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <a href="index.php?c=product&f=showAddForm" class="btn btn-primary" style="width: auto; margin-bottom: 24px;">
                <i class="fas fa-plus"></i> Tambah Produk Baru
            </a>

            <div class="info-card">
                <div class="card-header">
                    <h2><i class="fas fa-list"></i> Daftar Produk</h2>
                </div>
                <div class="card-body">
                    <table class="product-table" style="width: 100%; border-collapse: collapse;">
                        
                        <thead>
                            <tr style="background-color: #f4f7f6;">
                                <th style="padding: 12px; text-align: left;">Foto</th>
                                <th style="padding: 12px; text-align: left;">ID</th>
                                <th style="padding: 12px; text-align: left;">Nama Produk</th>
                                <th style="padding: 12px; text-align: left;">Harga</th>
                                <th style="padding: 12px; text-align: left;">Stok</th>
                                <th style="padding: 12px; text-align: left;">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($data['products'] as $product): ?>
                            <tr style="border-bottom: 1px solid #e2e8f0;">
                                
                                <td style="padding: 12px;">
                                    <?php if ($product->image_url): ?>
                                        <img src="public<?php echo htmlspecialchars($product->image_url); ?>" 
                                             alt="<?php echo htmlspecialchars($product->name); ?>" 
                                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                    <?php else: ?>
                                        <div style="width: 60px; height: 60px; background-color: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #aaa; font-size: 0.8rem;">
                                            No-img
                                        </div>
                                    <?php endif; ?>
                                </td>
                                
                                <td style="padding: 12px;">#<?php echo $product->id; ?></td>
                                <td style="padding: 12px;"><?php echo htmlspecialchars($product->name); ?></td>
                                <td style="padding: 12px;">Rp <?php echo number_format($product->price, 0, ',', '.'); ?></td>
                                <td style="padding: 12px;"><?php echo $product->stock; ?></td>
                                <td style="padding: 12px;">
                                  <a href="index.php?c=product&f=showEditForm&id=<?php echo $product->id; ?>" 
                                       style="color: #3b82f6; text-decoration: none;">Edit</a> |
                                    <a href="index.php?c=product&f=delete&id=<?php echo $product->id; ?>" 
                                       style="color: #ef4444; text-decoration: none;"
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">Hapus</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if (empty($data['products'])): ?>
                            <tr>
                                <td colspan="6" style="padding: 12px; text-align: center; color: #64748b;">
                                    Belum ada produk. Silakan tambahkan produk baru.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <script src="public/resource/dashboard.js"></script>
</body>
</html>