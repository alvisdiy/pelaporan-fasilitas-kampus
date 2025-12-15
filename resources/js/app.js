const CONFIG = {
    maxFileSize: 5 * 1024 * 1024, // 5MB
    allowedImageTypes: ['image/jpeg', 'image/png', 'image/jpg'],
    maxTextLength: 500
};

document.addEventListener('DOMContentLoaded', function() {
    console.log('Sistem Pelaporan Fasilitas - Initialized');
    
    setupFormValidation();
    
    setupDeleteConfirmations();
    
    setupAutoHideAlerts();
    
    setupCharacterCounters();
    
    setupDateFormatters();
    
    setupImagePreviews();
    
    setupToastSystem();
    
    setupActiveNavigation();
});

function setupFormValidation() {
    const forms = document.querySelectorAll('form[data-validate]');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                showToast('Harap isi semua field yang wajib diisi', 'error');
            }
        });
        
        // Real-time validation
        const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
        });
    });
}

function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!validateField(field)) {
            isValid = false;
        }
    });
    
    return isValid;
}

function validateField(field) {
    const value = field.value.trim();
    let isValid = true;
    let errorMessage = '';
    
    if (!value) {
        errorMessage = 'Field ini wajib diisi';
        isValid = false;
    }
    
    else if (field.type === 'email' && !isValidEmail(value)) {
        errorMessage = 'Format email tidak valid';
        isValid = false;
    }
    
    else if (field.type === 'file') {
        if (field.files.length > 0) {
            const file = field.files[0];
            
            // Cek tipe file
            if (!CONFIG.allowedImageTypes.includes(file.type)) {
                errorMessage = 'Hanya file gambar (JPG, PNG) yang diperbolehkan';
                isValid = false;
            }
            
            // Cek ukuran file
            else if (file.size > CONFIG.maxFileSize) {
                errorMessage = 'Ukuran file maksimal 5MB';
                isValid = false;
            }
        }
    }
    
    else if (field.type === 'number') {
        const min = field.getAttribute('min');
        const max = field.getAttribute('max');
        
        if (min && parseFloat(value) < parseFloat(min)) {
            errorMessage = `Nilai minimum adalah ${min}`;
            isValid = false;
        }
        
        if (max && parseFloat(value) > parseFloat(max)) {
            errorMessage = `Nilai maksimum adalah ${max}`;
            isValid = false;
        }
    }
    
    if (!isValid) {
        showFieldError(field, errorMessage);
    } else {
        clearFieldError(field);
        showFieldSuccess(field);
    }
    
    return isValid;
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    const errorDiv = document.createElement('div');
    errorDiv.className = 'field-error';
    errorDiv.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
    
    field.parentNode.appendChild(errorDiv);
    field.classList.add('error');
}

function clearFieldError(field) {
    const errorDiv = field.parentNode.querySelector('.field-error');
    if (errorDiv) {
        errorDiv.remove();
    }
    field.classList.remove('error');
}

function showFieldSuccess(field) {
    field.classList.add('success');
    setTimeout(() => field.classList.remove('success'), 3000);
}

function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function setupDeleteConfirmations() {
    const deleteForms = document.querySelectorAll('form[data-confirm-delete]');
    const deleteButtons = document.querySelectorAll('[data-action="delete"]');
    
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.')) {
                e.preventDefault();
                return false;
            }
            showToast('Menghapus data...', 'info');
        });
    });
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                e.preventDefault();
                return false;
            }
        });
    });
}

function setupAutoHideAlerts() {
    const alerts = document.querySelectorAll('.alert');
    
    alerts.forEach(alert => {
        // Tambahkan tombol close
        const closeBtn = document.createElement('button');
        closeBtn.className = 'alert-close';
        closeBtn.innerHTML = '<i class="fas fa-times"></i>';
        closeBtn.addEventListener('click', () => alert.remove());
        alert.appendChild(closeBtn);
        
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
}

function setupCharacterCounters() {
    const textareas = document.querySelectorAll('textarea[data-max-length]');
    
    textareas.forEach(textarea => {
        const maxLength = textarea.getAttribute('data-max-length') || CONFIG.maxTextLength;
        
        // Buat counter element
        const counterDiv = document.createElement('div');
        counterDiv.className = 'char-counter';
        textarea.parentNode.appendChild(counterDiv);
        
        function updateCounter() {
            const length = textarea.value.length;
            const remaining = maxLength - length;
            
            counterDiv.textContent = `${length}/${maxLength} karakter`;
            counterDiv.className = 'char-counter';
            
            if (remaining < 0) {
                counterDiv.classList.add('error');
                textarea.value = textarea.value.substring(0, maxLength);
                updateCounter();
            } else if (remaining < 50) {
                counterDiv.classList.add('warning');
            } else {
                counterDiv.classList.add('success');
            }
        }
        
        textarea.addEventListener('input', updateCounter);
        updateCounter(); // Initialize
    });
}

function setupDateFormatters() {
    const dateElements = document.querySelectorAll('[data-format-date]');
    
    dateElements.forEach(element => {
        const dateStr = element.getAttribute('data-format-date') || element.textContent;
        const date = new Date(dateStr);
        
        if (!isNaN(date)) {
            const formatted = formatDate(date);
            element.textContent = formatted;
            element.title = date.toLocaleString('id-ID');
        }
    });
}

function formatDate(date) {
    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    
    return date.toLocaleDateString('id-ID', options);
}

function setupImagePreviews() {
    const fileInputs = document.querySelectorAll('input[type="file"][accept^="image/"]');
    
    fileInputs.forEach(input => {
        let previewContainer = input.parentNode.querySelector('.image-preview');
        if (!previewContainer) {
            previewContainer = document.createElement('div');
            previewContainer.className = 'image-preview';
            input.parentNode.appendChild(previewContainer);
        }
        
        input.addEventListener('change', function() {
            previewImage(this, previewContainer);
        });
        
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'remove-image-btn';
        removeBtn.innerHTML = '<i class="fas fa-trash"></i> Hapus Gambar';
        removeBtn.style.display = 'none';
        removeBtn.addEventListener('click', () => {
            input.value = '';
            previewContainer.innerHTML = '';
            removeBtn.style.display = 'none';
        });
        
        input.parentNode.appendChild(removeBtn);
    });
}

function previewImage(input, container) {
    container.innerHTML = '';
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validasi file
        if (!CONFIG.allowedImageTypes.includes(file.type)) {
            showToast('Hanya file gambar (JPG, PNG) yang diperbolehkan', 'error');
            input.value = '';
            return;
        }
        
        if (file.size > CONFIG.maxFileSize) {
            showToast('Ukuran file maksimal 5MB', 'error');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.alt = 'Preview Image';
            img.style.maxWidth = '100%';
            img.style.maxHeight = '300px';
            img.style.borderRadius = '8px';
            
            container.appendChild(img);
            container.parentNode.querySelector('.remove-image-btn').style.display = 'block';
        };
        
        reader.readAsDataURL(file);
    }
}

function setupToastSystem() {
    const toastContainer = document.createElement('div');
    toastContainer.id = 'toast-container';
    document.body.appendChild(toastContainer);
    
    const style = document.createElement('style');
    style.textContent = `
        #toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .toast {
            min-width: 300px;
            padding: 15px 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideInRight 0.3s ease;
            transform-origin: top right;
        }
        
        .toast-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .toast-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .toast-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .toast-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .toast-close {
            margin-left: auto;
            background: none;
            border: none;
            cursor: pointer;
            opacity: 0.7;
            transition: opacity 0.3s;
        }
        
        .toast-close:hover {
            opacity: 1;
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
}

function showToast(message, type = 'success', duration = 5000) {
    const toastContainer = document.getElementById('toast-container');
    
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    let icon = 'info-circle';
    switch(type) {
        case 'success': icon = 'check-circle'; break;
        case 'error': icon = 'exclamation-circle'; break;
        case 'warning': icon = 'exclamation-triangle'; break;
        case 'info': icon = 'info-circle'; break;
    }
    
    toast.innerHTML = `
        <i class="fas fa-${icon}"></i>
        <span>${message}</span>
        <button class="toast-close">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    const closeBtn = toast.querySelector('.toast-close');
    closeBtn.addEventListener('click', () => {
        removeToast(toast);
    });
    
    toastContainer.appendChild(toast);
    
    if (duration > 0) {
        setTimeout(() => {
            removeToast(toast);
        }, duration);
    }
    
    return toast;
}

function removeToast(toast) {
    toast.style.animation = 'slideOutRight 0.3s ease';
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 300);
}

function setupActiveNavigation() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.navbar a');
    
    navLinks.forEach(link => {
        const linkPath = link.getAttribute('href');
        
        if (linkPath === currentPath || 
            (currentPath.startsWith(linkPath) && linkPath !== '/')) {
            link.classList.add('active');
        }
        
        // Highlight parent menu untuk nested routes
        if (currentPath.includes('/laporan') && linkPath.includes('/laporan')) {
            link.classList.add('active');
        }
    });
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

function formatNumber(num) {
    return new Intl.NumberFormat('id-ID').format(num);
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text)
        .then(() => showToast('Teks berhasil disalin', 'success'))
        .catch(err => showToast('Gagal menyalin teks', 'error'));
}

function generateId(prefix = '') {
    return prefix + Date.now().toString(36) + Math.random().toString(36).substr(2);
}

window.previewImage = function(input) {
    const container = input.parentNode.querySelector('.image-preview') || 
                     document.getElementById('imagePreview');
    if (container) {
        previewImage(input, container);
    }
};

window.removeImage = function() {
    const input = document.querySelector('input[type="file"]');
    const container = document.querySelector('.image-preview');
    
    if (input) input.value = '';
    if (container) container.innerHTML = '';
    
    const removeBtn = document.querySelector('.remove-image-btn');
    if (removeBtn) removeBtn.style.display = 'none';
};

window.confirmAction = function(message, callback) {
    if (confirm(message || 'Apakah Anda yakin?')) {
        if (typeof callback === 'function') {
            callback();
        }
        return true;
    }
    return false;
};

async function fetchData(url, options = {}) {
    try {
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            ...options
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return await response.json();
    } catch (error) {
        console.error('Fetch error:', error);
        showToast('Terjadi kesalahan saat mengambil data', 'error');
        throw error;
    }
}

console.log('JavaScript utilities loaded successfully');