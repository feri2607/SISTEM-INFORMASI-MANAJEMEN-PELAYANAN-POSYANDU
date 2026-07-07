<x-guest-layout>
    <div class="auth-card">
        <div class="p-8 sm:p-10">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-6">
                    <div class="p-4 bg-posyandu-50 dark:bg-posyandu-900/20 rounded-2xl">
                        <svg class="w-10 h-10 text-posyandu-600 dark:text-posyandu-400" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    Verifikasi Email
                </h2>
                <p class="mt-4 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                    Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi email Anda dengan mengklik link
                    yang baru saja kami kirimkan.
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div
                    class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-800 rounded-xl">
                    <p class="text-sm font-medium text-emerald-700 dark:text-emerald-400 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Link verifikasi baru telah dikirim ke alamat email Anda.
                    </p>
                </div>
            @endif

            <div class="space-y-6">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn-primary">
                        {{ __('Kirim Ulang Email Verifikasi') }}
                    </button>
                </form>

                <div class="flex items-center justify-center space-x-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="text-sm font-bold text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors uppercase tracking-widest">
                            {{ __('Keluar') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>