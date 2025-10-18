<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MVC App</title>
    <link rel="stylesheet" href="resource/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-cube"></i> MVC App</h2>
            </div>
            <nav class="sidebar-nav">
                <a href="index.php?c=user&f=dashboard" class="nav-item active">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-user"></i>
                    <span>Profile</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Analytics</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
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
                            <span class="user-role">Administrator</span>
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
            <div class="stats-grid">
                <div class="stat-card card-purple">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Users</h3>
                        <p class="stat-number">1,284</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 12% dari bulan lalu
                        </span>
                    </div>
                </div>

                <div class="stat-card card-blue">
                    <div class="stat-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Active Sessions</h3>
                        <p class="stat-number">856</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 8% dari bulan lalu
                        </span>
                    </div>
                </div>

                <div class="stat-card card-green">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Revenue</h3>
                        <p class="stat-number">$24.5K</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 23% dari bulan lalu
                        </span>
                    </div>
                </div>

                <div class="stat-card card-orange">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Satisfaction</h3>
                        <p class="stat-number">98.5%</p>
                        <span class="stat-change positive">
                            <i class="fas fa-arrow-up"></i> 2% dari bulan lalu
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
                                <p><?php echo date('d M Y'); ?></p>
                            </div>
                            <div class="info-item">
                                <label><i class="fas fa-clock"></i> Last Login:</label>
                                <p><?php echo date('d M Y, H:i'); ?></p>
                            </div>
                        </div>
                        <div class="card-actions">
                            <button class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Profile
                            </button>
                            <button class="btn btn-secondary">
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
                            <div class="activity-item">
                                <div class="activity-icon info">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-title">Profile Updated</p>
                                    <p class="activity-time">2 jam yang lalu</p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon warning">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-title">Security Check</p>
                                    <p class="activity-time">5 jam yang lalu</p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon success">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-title">Email Verified</p>
                                    <p class="activity-time">1 hari yang lalu</p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon info">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <div class="activity-content">
                                    <p class="activity-title">Account Created</p>
                                    <p class="activity-time">3 hari yang lalu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h2><i class="fas fa-bolt"></i> Quick Actions</h2>
                <div class="actions-grid">
                    <button class="action-btn">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add New</span>
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-download"></i>
                        <span>Export Data</span>
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-upload"></i>
                        <span>Import Data</span>
                    </button>
                    <button class="action-btn">
                        <i class="fas fa-file-alt"></i>
                        <span>Generate Report</span>
                    </button>
                </div>
            </div>
        </main>
    </div>

    <script src="resource/dashboard.js"></script>
</body>
</html>