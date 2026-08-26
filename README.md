# Manajemen Data Santri

Aplikasi web berbasis **Laravel 12** untuk mengelola data santri pesantren.

## Fitur

- **Dual Authentication**: Login Admin & Wali Santri (guard terpisah)
- **CRUD Santri Lengkap**: Form bertab untuk data pribadi, ayah, ibu, dan alamat
- **Manajemen Wali**: Admin kelola akun wali santri
- **Dashboard Statistik**: Ringkasan santri aktif/lulus/keluar
- **UI Modern**: Tailwind CSS + Font Awesome

## Struktur Database (9 Tabel)

`admins` | `wali_santri` | `santri` | `datasantri` | `dataayah` | `dataibu` | `alamatayah` | `alamatibu` | `alamatsantri`

## Instalasi

```bash
composer install
# Edit .env: DB_DATABASE=db_santri, DB_USERNAME, DB_PASSWORD
php artisan migrate --seed
php artisan serve
```

## Akun Default

| Role | Username | Password |
|------|----------|----------|
| Admin | `admin` | `admin123` |

## URL Akses

| URL | Deskripsi |
|-----|-----------|
| `/admin/login` | Login Admin |
| `/wali/login` | Login Wali Santri |
