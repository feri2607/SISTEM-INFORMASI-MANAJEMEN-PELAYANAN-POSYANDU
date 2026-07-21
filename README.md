# SISTEM INFORMASI MANAJEMEN PELAYANAN POSYANDU

## Deskripsi
Sistem Informasi Manajemen Pelayanan Posyandu berbasis Laravel untuk membantu pengelolaan data warga, kegiatan posyandu, pemeriksaan kesehatan, pelayanan balita, ibu hamil, remaja, lansia, serta pembuatan laporan.

## Teknologi
- Laravel
- PHP
- MySQL
- Tailwind CSS
- JavaScript

## Cara Menjalankan

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

## Author

Feri2607

# Hapus folder public\storage yang dibuat oleh php artisan storage:link (jika sudah ada)
Remove-Item -Recurse -Force public\storage

# Buat junction (pengganti symlink di Windows)
cmd /c mklink /J public\storage storage\app\public