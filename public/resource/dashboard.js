document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });

    const changePasswordModal = document.getElementById('changePasswordModal');
    const changePasswordBtn = document.getElementById('changePasswordBtn');
    const changePasswordForm = document.getElementById('changePasswordForm');
    const cpCloseBtn = document.querySelector('#changePasswordModal .close-btn');

    if (changePasswordBtn && changePasswordModal) {
        changePasswordBtn.onclick = function() {
            changePasswordModal.classList.add('show-modal');
        }
    }
    if (cpCloseBtn && changePasswordModal) {
        cpCloseBtn.onclick = function() {
            changePasswordModal.classList.remove('show-modal');
        }
    }
    if (changePasswordForm) {
        changePasswordForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('index.php?c=user&f=changePassword', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (changePasswordModal) changePasswordModal.classList.remove('show-modal');
                showNotification(data.message, data.success ? 'success' : 'error');
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan koneksi.', 'error');
            });
        });
    }

    const editProfileModal = document.getElementById('editProfileModal');
    const editProfileBtn = document.getElementById('editProfileBtn');
    const editProfileForm = document.getElementById('editProfileForm');
    const epCloseBtn = document.querySelector('#editProfileModal .close-btn');

    if (editProfileBtn && editProfileModal) {
        editProfileBtn.onclick = function() {
            editProfileModal.classList.add('show-modal');
        }
    }
    if (epCloseBtn && editProfileModal) {
        epCloseBtn.onclick = function() {
            editProfileModal.classList.remove('show-modal');
        }
    }
    if (editProfileForm) {
        editProfileForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch('index.php?c=user&f=updateProfile', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (editProfileModal) editProfileModal.classList.remove('show-modal');
                if (data.success) {
                    window.location.reload();
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Terjadi kesalahan koneksi.', 'error');
            });
        });
    }

    window.onclick = function(event) {
        if (event.target == changePasswordModal) {
            changePasswordModal.classList.remove('show-modal');
        }
        if (event.target == editProfileModal) {
            editProfileModal.classList.remove('show-modal');
        }
    }

    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('active');
    }

    document.querySelectorAll('.nav-item').forEach(item => {
        item.addEventListener('click', function(e) {
            document.querySelectorAll('.nav-item').forEach(nav => {
                nav.classList.remove('active');
            });
            if (!this.classList.contains('logout')) {
                this.classList.add('active');
            }
        });
    });

    function animateValue(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            let currentValue;
            if (end.toString().includes('$')) {
                const numValue = parseFloat(end.replace('$', '').replace('K', '')) * 1000;
                currentValue = '$' + (progress * numValue / 1000).toFixed(1) + 'K';
            } else if (end.toString().includes('%')) {
                const numValue = parseFloat(end.replace('%', ''));
                currentValue = (progress * numValue).toFixed(1) + '%';
            } else {
                const numValue = parseInt(end.toString().replace(/,/g, ''));
                 if(isNaN(numValue)) {
                    element.textContent = end;
                    return;
                }
                currentValue = Math.floor(progress * numValue).toLocaleString('id-ID');
            }
            element.textContent = currentValue;
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    window.addEventListener('load', function() {
        const statNumbers = document.querySelectorAll('.stat-number');
        statNumbers.forEach(stat => {
            const endValue = stat.textContent;
            stat.textContent = '0';
            animateValue(stat, 0, endValue, 1500);
        });
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.querySelector('span').textContent;
            alert('Aksi: ' + action + '\n\nFitur ini akan segera tersedia!');
        });
    });

    document.querySelectorAll('.stat-card, .info-card, .activity-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transition = 'all 0.3s ease';
        });
    });

    function updateTime() {
        const now = new Date();
        const options = {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        };
        const timeString = now.toLocaleDateString('id-ID', options);
        const timeElement = document.querySelector('.current-time');
        if (timeElement) {
            timeElement.textContent = timeString;
        }
    }
    updateTime();
    setInterval(updateTime, 60000);

    document.querySelectorAll('.btn, .action-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            if (this.id === 'changePasswordBtn' || this.id === 'editProfileBtn') return;
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            this.appendChild(ripple);
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x + 'px';
            ripple.style.top = y + 'px';
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            alert('Fitur pencarian akan segera hadir!');
        }
        if (e.key === 'Escape') {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.display = 'none';
            });
            if (changePasswordModal) {
                changePasswordModal.classList.remove('show-modal');
            }
             if (editProfileModal) {
                editProfileModal.classList.remove('show-modal');
            }
        }
    });

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type}`;
        notification.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
        const mainContent = document.querySelector('.main-content');
        mainContent.insertBefore(notification, mainContent.firstChild);
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }

    document.querySelectorAll('.activity-item').forEach(item => {
        item.addEventListener('click', function() {
            const title = this.querySelector('.activity-title').textContent;
            alert('Detail Aktivitas\n\n' + title);
        });
    });

    function showLoading() {
        const loader = document.createElement('div');
        loader.className = 'loader';
        loader.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        document.body.appendChild(loader);
    }

    function hideLoading() {
        const loader = document.querySelector('.loader');
        if (loader) {
            loader.remove();
        }
    }

    function initTooltips() {
        const elements = document.querySelectorAll('[data-tooltip]');
        elements.forEach(el => {
            el.addEventListener('mouseenter', function() {
                const tooltip = document.createElement('div');
                tooltip.className = 'tooltip';
                tooltip.textContent = this.getAttribute('data-tooltip');
                document.body.appendChild(tooltip);
                const rect = this.getBoundingClientRect();
                tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
                tooltip.style.left = rect.left + (rect.width - tooltip.offsetWidth) / 2 + 'px';
            });
            el.addEventListener('mouseleave', function() {
                const tooltip = document.querySelector('.tooltip');
                if (tooltip) {
                    tooltip.remove();
                }
            });
        });
    }

    initTooltips();
});
