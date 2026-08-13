# Deploy Laravel ke Hostinger

## Upload langsung ke `public_html`

Proyek ini sekarang memiliki `index.php` dan `.htaccess` di root, sehingga
seluruh isi proyek dapat di-upload langsung ke `public_html`. Apache akan
meneruskan request aplikasi ke folder `public` dan memblokir folder internal.

Pastikan file `.env` production sudah diisi dan folder `storage` dapat ditulis.
Jika memakai pengaturan document root khusus, tetap disarankan mengarahkannya
ke folder `public`.

Gunakan struktur ini di hosting agar folder aplikasi tidak terbuka ke publik:

```
/home/u123456789/
├── laravel_app/       # seluruh isi project ini (app, bootstrap, config, database, resources, routes, storage, vendor, .env)
└── public_html/       # isi dari folder hostinger/public_html pada project ini
```

## Langkah upload

1. Buat database MySQL di hPanel dan catat nama database, username, password, serta host.
2. Upload seluruh project ke `/home/u123456789/laravel_app/`. Jangan upload `.env` dari komputer; buat `.env` baru berdasarkan `.env.hostinger.example`.
3. Jalankan `composer install --no-dev --optimize-autoloader` di folder `laravel_app` (atau upload folder `vendor` yang sudah ada).
4. Salin isi folder `hostinger/public_html` ke `/home/u123456789/public_html/`.
5. Isi `.env` production, lalu jalankan:

```bash
php artisan key:generate --force
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan view:cache
```

6. Import database lama melalui phpMyAdmin bila ingin membawa data kunjungan yang sudah ada.

## Membuat akun admin di database

Akun admin disimpan di tabel `users`. Setelah migrasi, jalankan SQL ini di phpMyAdmin. Hash password dibuat oleh Laravel, bukan password teks biasa:

```sql
INSERT INTO users (name, email, password, created_at, updated_at)
VALUES ('Administrator', 'adim@hubinmas.com', '$2y$12$REPLACE_WITH_BCRYPT_HASH', NOW(), NOW());
```

Buat hash dengan perintah berikut di folder `laravel_app`, lalu ganti nilai hash pada SQL:

```bash
php -r "echo password_hash('mutu123', PASSWORD_BCRYPT), PHP_EOL;"
```

Jika email sudah ada, gunakan:

```sql
UPDATE users SET password = '$2y$12$REPLACE_WITH_BCRYPT_HASH', updated_at = NOW()
WHERE email = 'adim@hubinmas.com';
```

Login menggunakan `adim@hubinmas.com` dan `mutu123`.
