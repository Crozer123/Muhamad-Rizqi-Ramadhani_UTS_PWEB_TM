// Dashboard JavaScript

// Auto hide alert after 5 seconds
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
});

// Mobile sidebar toggle
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('active');
}

// Add click event to nav items
document.querySelectorAll('.nav-item').forEach(item => {
    item.addEventListener('click', function(e) {
        // Remove active class from all items
        document.querySelectorAll('.nav-item').forEach(nav => {
            nav.classList.remove('active');
        });
        
        // Add active class to clicked item (except logout)
        if (!this.classList.contains('logout')) {
            this.classList.add('active');
        }
    });
});

// Animate stat numbers on page load
function animateValue(element, start, end, duration) {
    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        
        // Parse number (remove $ and K)
        let currentValue;
        if (end.toString().includes('$')) {
            const numValue = parseFloat(end.replace('$', '').replace('K', '')) * 1000;
            currentValue = '$' + (progress * numValue / 1000).toFixed(1) + 'K';
        } else if (end.toString().includes('%')) {
            const numValue = parseFloat(end.replace('%', ''));
            currentValue = (progress * numValue).toFixed(1) + '%';
        } else if (end.toString().includes(',')) {
            const numValue = parseInt(end.replace(',', ''));
            currentValue = Math.floor(progress * numValue).toLocaleString();
        } else {
            currentValue = Math.floor(progress * end);
        }
        
        element.textContent = currentValue;
        
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

// Animate all stat numbers
window.addEventListener('load', function() {
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        const endValue = stat.textContent;
        stat.textContent = '0';
        animateValue(stat, 0, endValue, 1500);
    });
});

// Smooth scroll for internal links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
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

// Action buttons functionality
document.querySelectorAll('.action-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const action = this.querySelector('span').textContent;
        alert('Action: ' + action + '\n\nFitur ini akan segera tersedia!');
    });
});

// Profile edit button
const editProfileBtn = document.querySelector('.btn-primary');
if (editProfileBtn) {
    editProfileBtn.addEventListener('click', function() {
        alert('Edit Profile\n\nFitur edit profile akan segera tersedia!');
    });
}

// Change password button
const changePasswordBtn = document.querySelector('.btn-secondary');
if (changePasswordBtn) {
    changePasswordBtn.addEventListener('click', function() {
        alert('Change Password\n\nFitur ganti password akan segera tersedia!');
    });
}

// Add hover effect to cards
document.querySelectorAll('.stat-card, .info-card, .activity-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transition = 'all 0.3s ease';
    });
});

// Console welcome message
console.log('%c🎉 Welcome to MVC Dashboard! 🎉', 'color: #667eea; font-size: 20px; font-weight: bold;');
console.log('%cDashboard loaded successfully!', 'color: #43e97b; font-size: 14px;');
console.log('%cBuilt with PHP MVC Pattern', 'color: #764ba2; font-size: 12px;');

// Update current time
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
    
    // Update if element exists
    const timeElement = document.querySelector('.current-time');
    if (timeElement) {
        timeElement.textContent = timeString;
    }
}

// Update time every minute
updateTime();
setInterval(updateTime, 60000);

// Add ripple effect to buttons
document.querySelectorAll('.btn, .action-btn').forEach(button => {
    button.addEventListener('click', function(e) {
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

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Ctrl/Cmd + K for search (placeholder)
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
        e.preventDefault();
        alert('Search feature coming soon!');
    }
    
    // ESC to close alerts
    if (e.key === 'Escape') {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            alert.style.display = 'none';
        });
    }
});

// Print function
function printDashboard() {
    window.print();
}

// Export data function (placeholder)
function exportData() {
    alert('Export Data\n\nFitur export akan segera tersedia!');
}

// Refresh stats
function refreshStats() {
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        stat.style.opacity = '0';
        setTimeout(() => {
            stat.style.opacity = '1';
        }, 100);
    });
    
    // Show notification
    showNotification('Stats refreshed!', 'success');
}

// Show notification function
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

// Activity item click
document.querySelectorAll('.activity-item').forEach(item => {
    item.addEventListener('click', function() {
        const title = this.querySelector('.activity-title').textContent;
        alert('Activity Details\n\n' + title);
    });
});

// Add loading state for async operations
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

// Initialize tooltips (if needed)
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

// Initialize on page load
initTooltips();

// Log page performance
window.addEventListener('load', function() {
    const loadTime = window.performance.timing.domContentLoadedEventEnd - window.performance.timing.navigationStart;
    console.log('%cPage loaded in: ' + loadTime + 'ms', 'color: #43e97b; font-weight: bold;');
});