<?php $product = $data['product']; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk - Rizqi App</title>
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
                    <h1>Edit Produk</h1>
                    <p class="breadcrumb"><i class="fas fa-home"></i> Home / Produk / Edit</p>
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
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="info-card">
                <div class="card-header">
                    <h2><i class="fas fa-edit"></i> Detail Produk #<?php echo $product->id; ?></h2>
                </div>
                <div class="card-body">
                   <form action="index.php?c=product&f=update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $product->id; ?>">

                        <div class="input-group" style="margin-bottom: 16px;">
                            <label for="name">Nama Produk</label>
                            <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($product->name); ?>" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;">
                        </div>
                         <div class="input-group" style="margin-bottom: 16px;">
                            <label for="description">Deskripsi</label>
                            <textarea id="description" name="description" rows="4" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;"><?php echo htmlspecialchars($product->description); ?></textarea>
                        </div>
                        <div class="info-grid" style="grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 16px;">
                            <div class="input-group">
                                <label for="price">Harga (Rp)</label>
                                <input type="number" id="price" name="price" required value="<?php echo htmlspecialchars($product->price); ?>" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;">
                            </div>
                            <div class="input-group">
                                <label for="stock">Stok</label>
                                <input type="number" id="stock" name="stock" required value="<?php echo htmlspecialchars($product->stock); ?>" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;">
                            </div>
                        </div>
                        <div class="input-group" style="margin-bottom: 16px;">
                            <label for="product_image">Ganti Foto Produk (Kosongkan jika tidak ingin ganti)</label>
                            <?php if ($product->image_url): ?>
                                <div style="margin-bottom: 10px;">
                                    <img src="<?php echo htmlspecialchars($product->image_url); ?>" alt="Current Image" style="max-width: 100px; max-height: 100px; border-radius: 8px;">
                                    <small style="display: block; color: #666;">Gambar saat ini.</small>
                                </div>
                            <?php endif; ?>
                            <input type="file" id="product_image" name="product_image" accept="image/jpeg, image/png" style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;">
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: auto;">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                         <a href="index.php?c=product&f=showList" class="btn btn-secondary" style="width: auto; margin-left: 10px;">
                             Batal
                        </a>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <script src="resource/dashboard.js"></script>
</body>
</html>