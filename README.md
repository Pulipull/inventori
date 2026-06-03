# Inventori Laravel 12

Aplikasi inventori berbasis Laravel 12, PostgreSQL Neon, Blade, Tailwind CSS, Laravel Reverb, Docker, dan Traefik.

## Instalasi

1. File `.env` sudah disiapkan. Jika ingin membuat ulang dari template, salin `.env.example`.

```bash
cp .env.example .env
```

2. Isi credential PostgreSQL Neon di `.env`.

```env
DB_HOST=ep-xxxxx.ap-southeast-1.aws.neon.tech
DB_PORT=5432
DB_DATABASE=nama_database
DB_USERNAME=nama_user
DB_PASSWORD=password_neon
DB_SSLMODE=require
```

3. Jalankan container.

```bash
docker compose up -d
```

Jika membuat ulang `.env` dari `.env.example`, buat app key setelah container hidup.

```bash
docker compose exec app php artisan key:generate
```

4. Jalankan migrasi dan seeder dari dalam container.

```bash
docker compose exec app php artisan migrate --seed
```

5. Buka aplikasi di `http://inventori.localhost`.

Dashboard Traefik tersedia di `http://localhost:8080/dashboard/`.

## Akun Seeder

- Admin: `admin@example.com` / `password`
- Petugas: `petugas@example.com` / `password`

## Catatan

- Jangan menaruh credential database di repository.
- Untuk command lokal tanpa PHP terpasang, gunakan `docker compose exec app php artisan ...`.
- Reverb berjalan pada service `reverb` di port `6001` untuk chat real-time.
