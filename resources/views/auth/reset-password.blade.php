{{-- resources/views/auth/reset-password.blade.php --}}

<x-guest-layout>
    <div class="space-y-6" x-data="{ 
        showPassword: false, 
        showConfirmPassword: false,
        loading: false,
        email: '{{ old('email') }}',
        password: '',
        password_confirmation: '',
        submitForm() {
            this.loading = true;
            this.$refs.resetForm.submit();
        },
        getPasswordStrength() {
            const password = this.password;
            let strength = 0;
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            return strength;
        },
        getStrengthText() {
            const strength = this.getPasswordStrength();
            if (strength <= 2) return 'Lemah';
            if (strength <= 3) return 'Sedang';
            if (strength <= 4) return 'Kuat';
            return 'Sangat Kuat';
        },
        getStrengthColor() {
            const strength = this.getPasswordStrength();
            if (strength <= 2) return 'bg-red-500';
            if (strength <= 3) return 'bg-yellow-500';
            if (strength <= 4) return 'bg-green-500';
            return 'bg-emerald-500';
        },
        getStrengthWidth() {
            const strength = this.getPasswordStrength();
            return (strength / 5) * 100 + '%';
        }
    }">
        <div class="auth-card">
            <div class="p-8 sm:p-10">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="flex justify-center mb-6">
                        <div class="p-4 bg-posyandu-50 dark:bg-posyandu-900/20 rounded-2xl">
                            <svg class="w-10 h-10 text-posyandu-600 dark:text-posyandu-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                        Reset Password
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Silakan masukkan password baru Anda.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <!-- Reset Password Form -->
                <form method="POST" action="{{ route('password.update') }}" x-ref="resetForm"
                    @submit.prevent="submitForm" class="space-y-6">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

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
                                required autocomplete="username" placeholder="nama@email.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="form-error" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password Baru')" class="form-label" />
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
                                autocomplete="new-password" placeholder="Minimal 8 karakter" />
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

                        <!-- Password Strength Indicator -->
                        <div x-show="password.length > 0" x-cloak class="mt-3">
                            <div class="flex items-center justify-between mb-1.5">
                                <span
                                    class="text-[10px] uppercase tracking-wider font-bold text-gray-500 dark:text-gray-400">
                                    Kekuatan Password
                                </span>
                                <span class="text-[10px] uppercase tracking-wider font-bold" :class="{
                                          'text-red-600': getPasswordStrength() <= 2,
                                          'text-yellow-600': getPasswordStrength() === 3,
                                          'text-green-600': getPasswordStrength() === 4,
                                          'text-emerald-600': getPasswordStrength() >= 5
                                      }" x-text="getStrengthText()">
                                </span>
                            </div>
                            <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-500" :class="getStrengthColor()"
                                    :style="{ width: getStrengthWidth() }">
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1.5">
                            <template x-for="(met, label) in {
                                'Minimal 8 karakter': password.length >= 8,
                                'Huruf kecil & besar': password.match(/[a-z]/) && password.match(/[A-Z]/),
                                'Angka': password.match(/[0-9]/),
                                'Simbol': password.match(/[^a-zA-Z0-9]/)
                            }">
                                <div class="flex items-center text-[11px] transition-colors duration-200"
                                    :class="met ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-400 dark:text-gray-500'">
                                    <svg class="w-3 h-3 mr-1.5" :class="met ? 'opacity-100' : 'opacity-40'" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span x-text="label"></span>
                                </div>
                            </template>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="form-error" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')"
                            class="form-label" />
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400 dark:text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <input id="password_confirmation" x-model="password_confirmation"
                                class="form-input pl-11 pr-12" :type="showConfirmPassword ? 'text' : 'password'"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Masukkan ulang password" />
                            <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-posyandu-600 dark:text-gray-500 dark:hover:text-posyandu-400 transition duration-150">
                                <svg x-show="!showConfirmPassword" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="showConfirmPassword" x-cloak class="w-5 h-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.046m4.099-4.099A9.954 9.954 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21m-2.101-2.101L3 3m9 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        <div x-show="password_confirmation.length > 0 && password.length > 0" x-cloak
                            class="mt-2 text-[11px] font-bold"
                            :class="password === password_confirmation ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400'">
                            <span
                                x-text="password === password_confirmation ? '✓ Password sudah cocok' : '✗ Password belum cocok'"></span>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="form-error" />
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
                        <span x-text="loading ? 'Memproses...' : '{{ __('Update Password') }}'"></span>
                    </button>
                </form>

                <!-- Back to Login -->
                <div class="text-center mt-8">
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center text-sm text-posyandu-600 hover:text-posyandu-700 dark:text-posyandu-400 dark:hover:text-posyandu-300 font-bold transition duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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