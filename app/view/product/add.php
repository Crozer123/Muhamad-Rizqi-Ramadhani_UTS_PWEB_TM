<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Rizqi App</title>
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
                    <h1>Tambah Produk Baru</h1>
                    <p class="breadcrumb"><i class="fas fa-home"></i> Home / Produk / Tambah</p>
                </div>
                <div class="header-right">
                    <div class="user-info">
                        <div class="user-details">
                            <span class="user-name"><?php echo htmlspecialchars($_SESSION['nama']); ?></span>
                            <span class="user-role">Administrator</span>
                        </div>
                        <div class="user-avatar">
                            <?php echo strtoupper(substr($_SESSION['nama'], 0, 1)); ?>
                        </div>
                    </div>
                </div>
            </header>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="info-card">
                <div class="card-header">
                    <h2><i class="fas fa-edit"></i> Detail Produk</h2>
                </div>
                <div class="card-body">
                   <form action="index.php?c=product&f=add" method="POST" enctype="multipart/form-data">
                        <div class="input-group" style="margin-bottom: 16px;">
                            <label for="name" style="font-size: 0.9rem; color: #475569; font-weight: 500; margin-bottom: 8px; display: block;">Nama Produk</label>
                            <input type="text" id="name" name="name" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;">
                        </div>
                         <div class="input-group" style="margin-bottom: 16px;">
                            <label for="description" style="font-size: 0.9rem; color: #475569; font-weight: 500; margin-bottom: 8px; display: block;">Deskripsi</label>
                            <textarea id="description" name="description" rows="4" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;"></textarea>
                        </div>
                        <div class="info-grid" style="grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 16px;">
                            <div class="input-group">
                                <label for="price" style="font-size: 0.9rem; color: #475569; font-weight: 500; margin-bottom: 8px; display: block;">Harga (Rp)</label>
                                <input type="number" id="price" name="price" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;">
                            </div>
                            <div class="input-group">
                                <label for="stock" style="font-size: 0.9rem; color: #475569; font-weight: 500; margin-bottom: 8px; display: block;">Stok</label>
                                <input type="number" id="stock" name="stock" required style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;">
                            </div>
                        </div>
                        <div class="input-group" style="margin-bottom: 16px;">
                            <label for="product_image" style="font-size: 0.9rem; color: #475569; font-weight: 500; margin-bottom: 8px; display: block;">Foto Produk</label>
                            <input type="file" id="product_image" name="product_image" accept="image/jpeg, image/png" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;">
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: auto;">
                            <i class="fas fa-save"></i> Simpan Produk
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="public/resource/dashboard.js"></script>
</body>
</html>