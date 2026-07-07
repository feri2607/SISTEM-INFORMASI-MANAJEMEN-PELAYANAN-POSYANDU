{{-- resources/views/auth/login.blade.php --}}

<x-guest-layout>
    <div class="space-y-6" x-data="{ 
        showPassword: false, 
        loading: false,
        email: '{{ old('email') }}',
        password: '',
        remember: false,
        submitForm() {
            this.loading = true;
            this.$refs.loginForm.submit();
        }
    }">

        <div class="auth-card">
            <div class="p-8 sm:p-10">
                <div class="flex flex-col items-center text-center mb-8">
                    <img alt="Posyandu Logo" class="h-20 w-auto mb-6"
                        src="{{ setting('app_logo_main') ? Storage::url(setting('app_logo_main')) : asset('images/posyandu-logo.png') }}" />
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        Selamat Datang
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Silakan login untuk mengakses sistem.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" x-ref="loginForm" @submit.prevent="submitForm"
                    class="space-y-6">
                    @csrf

                    <!-- Email Address -->
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

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <x-input-label for="password" :value="__('Password')" class="form-label mb-0" />
                            @if (Route::has('password.request'))
                                <a class="text-xs font-semibold text-posyandu-600 hover:text-posyandu-700 dark:text-posyandu-400 dark:hover:text-posyandu-300 transition duration-150"
                                    href="{{ route('password.request') }}">
                                    {{ __('Lupa Password?') }}
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 dark:text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" x-model="password" class="form-input pl-11 pr-12"
                                :type="showPassword ? 'text' : 'password'" name="password" required
                                autocomplete="current-password" placeholder="••••••••" />
                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-posyandu-600 dark:text-gray-500 dark:hover:text-posyandu-400 transition duration-150">
                                <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showPassword" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.046m4.099-4.099A9.954 9.954 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-2.101-2.101L3 3m9 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="form-error" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" x-model="remember"
                            class="w-4 h-4 text-posyandu-600 bg-gray-50 border-gray-300 rounded focus:ring-2 focus:ring-posyandu-500 dark:bg-gray-700 dark:border-gray-600 transition duration-200"
                            name="remember" />
                        <label for="remember_me" class="ml-2.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Ingat Saya') }}
                        </label>
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
                        <span x-text="loading ? 'Memproses...' : '{{ __('Login ke Sistem') }}'"></span>
                    </button>
                </form>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200 dark:border-gray-700"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white dark:bg-gray-800 text-gray-500 dark:text-gray-400 font-medium">
                            atau login dengan
                        </span>
                    </div>
                </div>

                <!-- Social Login -->
                <a href="{{ route('auth.redirect', 'google') }}" class="btn-google">
                    <svg class="w-5 h-5 mr-3" viewBox="0 0 48 48">
                        <path fill="#EA4335"
                            d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                        <path fill="#4285F4"
                            d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                        <path fill="#FBBC05"
                            d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24s.92 7.54 2.56 10.78l7.97-6.19z" />
                        <path fill="#34A853"
                            d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                        <path fill="none" d="M0 0h48v48H0z" />
                    </svg>
                    <span>Google Account</span>
                </a>

                <!-- Register Link -->
                <p class="text-center mt-8 text-sm text-gray-600 dark:text-gray-400">
                    Belum punya akun?
                    <a href="{{ route('register') }}"
                        class="text-posyandu-600 hover:text-posyandu-700 dark:text-posyandu-400 dark:hover:text-posyandu-300 font-bold hover:underline underline-offset-4 transition duration-150">
                        Daftar Sekarang
                    </a>
                </p>
            </div>
        </div>

    </div>
</x-guest-layout>