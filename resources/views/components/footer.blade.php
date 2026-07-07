{{-- resources/views/components/footer.blade.php --}}

<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
    <div class="px-4 py-4 flex flex-col md:flex-row items-center justify-between text-sm">
        <div class="text-gray-600 dark:text-gray-400">
            &copy; {{ date('Y') }} <span class="font-semibold text-gray-900 dark:text-white">Sistem Informasi
                Posyandu</span>. All rights reserved.
        </div>
        <div class="flex items-center space-x-4 mt-2 md:mt-0">
            <span class="text-gray-500 dark:text-gray-400">Versi 1.0.0</span>
            <span class="text-gray-300 dark:text-gray-600">|</span>
            <span class="text-gray-500 dark:text-gray-400">Laravel {{ app()->version() }}</span>
        </div>
    </div>
</footer>