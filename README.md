# Pelaporan Fasilitas Kampus

## Branching
- `main` → versi stabil
- `dev` → pengembangan
- `feature/<nama-fitur>` → pengerjaan fitur

## Cara Setup
```bash
git clone <url-repo>
cd pelaporan-fasilitas-kampus

git checkout dev
git pull origin dev

composer install

cp .env.example .env
php artisan key:generate

//Atur database di file .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

php artisan migrate
