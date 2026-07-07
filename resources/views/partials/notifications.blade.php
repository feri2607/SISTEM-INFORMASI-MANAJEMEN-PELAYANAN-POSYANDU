{{-- resources/views/partials/notifications.blade.php --}}

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Constants for theme colors
        const COLORS = {
            success: '#3B82F6', // Blue-500
            error: '#EF4444',   // Red-500
            info: '#3B82F6',    // Blue-500
            warning: '#F59E0B'  // Amber-500
        };

        const swalConfig = {
            timer: 3000,
            timerProgressBar: true,
            showConfirmButton: true,
            confirmButtonText: 'OK',
        };

        // Flash message handling
        @if(session('success'))
            Swal.fire({
                ...swalConfig,
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: COLORS.success,
            });
        @endif

        @if(session('error'))
            Swal.fire({
                ...swalConfig,
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: COLORS.error,
            });
        @endif

        @if(session('info'))
            Swal.fire({
                ...swalConfig,
                icon: 'info',
                title: 'Informasi',
                text: '{{ session('info') }}',
                confirmButtonColor: COLORS.info,
            });
        @endif

        @if(session('warning'))
            Swal.fire({
                ...swalConfig,
                icon: 'warning',
                title: 'Peringatan',
                text: '{{ session('warning') }}',
                confirmButtonColor: COLORS.warning,
            });
        @endif

            // Validation errors handling
            @if($errors->any())
                let errorMessages = '';
                @foreach($errors->all() as $error)
                    errorMessages += '• {{ $error }}\n';
                @endforeach
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    text: errorMessages,
                    confirmButtonColor: COLORS.error,
                    confirmButtonText: 'Tutup',
                });
            @endif
    });
</script>