<x-guest-layout>
    <div class="space-y-6" x-data="{ 
        loading: false,
        email: '{{ old('email') }}',
        submitForm() {
            this.loading = true;
            this.$refs.forgotForm.submit();
        }
    }">
        <div class="auth-card">
            <div class="p-8 sm:p-10">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-6">
                        <div class="flex flex-col items-center text-center mb-8">
                            <img alt="Posyandu Logo" class="h-28 w-auto mb-6"
                                src="{{ setting('app_logo_main') ? Storage::url(setting('app_logo_main')) : asset('images/posyandu-logo.png') }}" />
                        </div>

                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        Lupa Password
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Masukkan email Anda untuk menerima link reset password.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <!-- Forgot Password Form -->
                <form method="POST" action="{{ route('password.email') }}" x-ref="forgotForm"
                    @submit.prevent="submitForm" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <x-input-label for="email" :value="__('Alamat Email')" class="form-label" />
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 dark:text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input id="email" x-model="email" class="form-input pl-11" type="email" name="email"
                                required autofocus autocomplete="username" placeholder="nama@email.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="form-error" />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-primary" :disabled="loading">
                        <svg x-show="loading" x-cloak class="animate-spin h-5 w-5 mr-2 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        <span x-text="loading ? 'Mengirim...' : '{{ __('Kirim Link Reset Password') }}'"></span>
                    </button>
                </form>

                <!-- Back to Login -->
                <div class="text-center mt-8">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center text-sm text-posyandu-600 hover:text-posyandu-700 dark:text-posyandu-400 dark:hover:text-posyandu-300 font-bold transition duration-150 group">
                        <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>