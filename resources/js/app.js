// resources/js/app.js

// 1. Core & Dependencies
import './bootstrap'; // Otomatis mengimpor axios dan mengonfigurasi header X-Requested-With
import 'flowbite';
import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';
import Alpine from 'alpinejs';

// 2. Global Bindings (Agar bisa diakses langsung dari file Blade)
window.Swal = Swal;
window.Chart = Chart;
window.Alpine = Alpine;

// 3. Initialize Alpine.js (Cukup dipanggil 1 kali saja di sini)
Alpine.start();

/**
 * Toggle visibilitas input password (Show/Hide)
 * @param {string} inputId
 * @param {string} iconId
 */
window.togglePasswordVisibility = function (inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);

    if (!input || !icon) return;

    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.046m4.099-4.099A9.954 9.954 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-2.101-2.101L3 3m9 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        `;
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
    }
};

/**
 * Global confirmation dialog menggunakan SweetAlert2
 * @param {string} message
 * @param {function} callback
 */
window.confirmDelete = function (message, callback) {
    if (typeof Swal === 'undefined') {
        if (confirm(message || 'Apakah Anda yakin ingin menghapus data ini?')) {
            callback();
        }
        return;
    }

    Swal.fire({
        title: 'Konfirmasi Hapus',
        text: message || 'Apakah Anda yakin ingin menghapus data ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#EF4444',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
};

/**
 * Auto-hide pesan flash/alert notifikasi (Mendukung class .flash-message dan .alert-message)
 */
document.addEventListener('DOMContentLoaded', function () {
    const alerts = document.querySelectorAll('.flash-message, .alert-message');

    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });
});
