<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Rizqi App</title>
    <link rel="stylesheet" href="/public/resource/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<?php
        $growthClass = ($data['userGrowthPercentage'] >= 0) ? 'positive' : 'negative';
        $growthIcon = ($data['userGrowthPercentage'] >= 0) ? 'fa-arrow-up' : 'fa-arrow-down';
    ?>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-cube"></i> Rizqi App</h2>
            </div>
            <nav class="sidebar-nav">
                <a href="index.php?c=user&f=dashboard" class="nav-item active">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="index.php?c=product&f=showList" class="nav-item">
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
                    <h1>Dashboard</h1>
                    <p class="breadcrumb"><i class="fas fa-home"></i> Home / Dashboard</p>
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
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <div class="stats-grid">
                <div class="stat-card card-purple">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Users</h3>
                        <p class="stat-number"><?php echo $data['totalUsers']; ?></p>
                        <span class="stat-change <?php echo $growthClass; ?>">
                            <i class="fas <?php echo $growthIcon; ?>"></i> <?php echo abs($data['userGrowthPercentage']); ?>% dari bulan lalu
                        </span>
                    </div>
                </div>
                 <div class="stat-card card-blue">
                    <div class="stat-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div class="stat-info">
                        <h3>New Users</h3>
                        <p class="stat-number"><?php echo $data['newUsersThisMonth']; ?></p>
                        <span class="stat-change positive">
                           Bulan ini
                        </span>
                    </div>
                </div>
            </div>

            <div class="content-grid">
                <div class="info-card">
                    <div class="card-header">
                        <h2><i class="fas fa-user-circle"></i> Informasi Akun</h2>
                    </div>
                    <div class="card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <label><i class="fas fa-user"></i> Nama Lengkap:</label>
                                <p><?php echo htmlspecialchars($_SESSION['nama']); ?></p>
                            </div>
                            <div class="info-item">
                                <label><i class="fas fa-envelope"></i> Email:</label>
                                <p><?php echo htmlspecialchars($_SESSION['email']); ?></p>
                            </div>
                            <div class="info-item">
                                <label><i class="fas fa-id-card"></i> User ID:</label>
                                <p>#<?php echo htmlspecialchars($_SESSION['userid']); ?></p>
                            </div>
                            <div class="info-item">
                                <label><i class="fas fa-check-circle"></i> Status:</label>
                                <p><span class="badge badge-success"><i class="fas fa-circle"></i> Active</span></p>
                            </div>
                            <div class="info-item">
                                <label><i class="fas fa-calendar"></i> Member Since:</label>
                                <p><?php echo isset($_SESSION['created_at']) ? date('d M Y', strtotime($_SESSION['created_at'])) : 'N/A'; ?></p>
                            </div>
                            <div class="info-item">
                                <label><i class="fas fa-clock"></i> Last Login:</label>
                                <p><?php echo isset($_SESSION['last_login']) && $_SESSION['last_login'] ? date('d M Y, H:i', strtotime($_SESSION['last_login'])) : 'Sesi ini'; ?></p>
                            </div>
                        </div>
                        <div class="card-actions">
                            <button id="editProfileBtn" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Profile
                            </button>
                            <button id="changePasswordBtn" class="btn btn-secondary">
                                <i class="fas fa-key"></i> Change Password
                            </button>
                        </div>
                    </div>
                </div>
                <div class="activity-card">
                    <div class="card-header">
                        <h2><i class="fas fa-history"></i> Aktivitas Terbaru</h2>
                    </div>
                    <div class="card-body">
                        <div class="activity-list">
                            <div class="activity-item">
                                <div class="activity-icon success">
                                    <i class="fas fa-sign-in-alt"></i>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-title">Login Berhasil</p>
                                    <p class="activity-time">Baru saja</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <div id="changePasswordModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Ganti Password</h2>
                <span class="close-btn">&times;</span>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm" method="POST">
                    <div class="input-group">
                        <label for="current_password">Password Saat Ini</label>
                        <input type="password" id="current_password" name="current_password" required>
                    </div>
                    <div class="input-group">
                        <label for="new_password">Password Baru</label>
                        <input type="password" id="new_password" name="new_password" required>
                    </div>
                    <div class="input-group">
                        <label for="confirm_new_password">Konfirmasi Password Baru</label>
                        <input type="password" id="confirm_new_password" name="confirm_new_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>

        <div id="editProfileModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Edit Profil</h2>
                    <span class="close-btn">&times;</span>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm" method="POST">
                        <div class="input-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($_SESSION['nama']); ?>" required>
                        </div>
                        <div class="input-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($_SESSION['email']); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>

    <script src="public/resource/dashboard.js"></script>
</body>
</html>