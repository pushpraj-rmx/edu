# Uni PHP

Laravel 12 application.

## Deploying to shared hosting (e.g. Hostinger)

Shared hosting usually has a fixed document root (e.g. `public_html`). Follow these steps to run the app with the web server pointing at Laravel’s `public` folder.

### 1. Requirements

-   **PHP 8.2+** (PHP 8.4 recommended). Enable extensions: `ctype`, `curl`, `dom`, `fileinfo`, `json`, `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`.
-   **MySQL** or **MariaDB** (create a database and user in the hosting panel).
-   **Composer** (on the server via SSH, or run locally and upload `vendor`).
-   **Node/pnpm** only for building assets; you can build locally and upload.

### 2. Build assets locally

Before uploading (or if the host has no Node):

```bash
pnpm install
pnpm run build
```

This creates `public/build/` (JS/CSS). Upload that folder so it exists under `public/` on the server.

### 3. Upload the project

-   Upload the whole project (e.g. via FTP/SFTP or Git) into a folder **outside** `public_html`, e.g. `laravel` or `uni-php`, so the structure on the server looks like:

    ```
    home/your_user/
    ├── laravel/           # or uni-php – app root
    │   ├── app/
    │   ├── bootstrap/
    │   ├── config/
    │   ├── database/
    │   ├── public/        # must contain index.php, .htaccess, build/, etc.
    │   ├── resources/
    │   ├── routes/
    │   ├── storage/
    │   ├── vendor/       # from composer (see step 4)
    │   ├── .env
    │   ├── artisan
    │   └── composer.json
    │   ...
    └── public_html/      # document root – see step 5
    ```

-   Do **not** put `.env` in version control; create it on the server (step 4).
-   Ensure `storage/` and `bootstrap/cache/` are writable (e.g. `chmod -R 775 storage bootstrap/cache`). On shared hosting, `775` or `755` is typical; use what your host recommends.

### 4. Install dependencies and configure env

**Option A – SSH available**

```bash
cd /path/to/your/laravel
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
# Edit .env (DB_*, APP_URL, APP_ENV=production, APP_DEBUG=false)
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

**Option B – No SSH**

-   Run `composer install --no-dev --optimize-autoloader` **locally** (same PHP major version as host), then upload the `vendor/` folder.
-   Create `.env` in the host’s file manager (copy from `.env.example`), set `APP_KEY=` and run `php artisan key:generate` if you get a one-line PHP runner, or set a key from local: `php artisan key:generate --show`.
-   Run migrations via a one-off script or host’s “Run PHP script” if available; otherwise use phpMyAdmin to run migrations manually (not ideal).
-   Run `php artisan storage:link` if your host allows; otherwise add a symlink or copy for `public/storage` → `../storage/app/public` if you use public disk.

### 5. Point document root to `public`

The site must be served from the Laravel **`public`** directory, not the project root.

-   **If the host lets you change document root:** set it to the `public` folder of your project, e.g. `.../laravel/public` or `.../uni-php/public`.
-   **If you can only use `public_html`:**
    -   Either move/copy the **contents** of `laravel/public/` into `public_html/` (index.php, .htaccess, build/, favicon, etc.).
    -   Then edit `public_html/index.php`: change the two `__DIR__.'/..'` paths so they point to the project root, e.g. `__DIR__.'/../laravel'` (adjust path to match your folder name).
    -   Or create a symlink: `public_html` → `laravel/public` (if the panel allows symlinks).

Your `public/.htaccess` is already set up for Laravel; keep it when copying to `public_html`.

### 6. `.env` on production

Example (MySQL, production):

```env
APP_NAME="Uni PHP"
APP_ENV=production
APP_KEY=base64:...   # from key:generate
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_user
DB_PASSWORD=your_password

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

Use strong `APP_KEY`, real DB credentials, and `APP_URL` with your domain (https if you use SSL).

### 7. Queues and cron (optional)

If you use the database queue:

-   **Cron:** add a job that runs every minute, e.g.  
    `* * * * * php /path/to/laravel/artisan schedule:run >> /dev/null 2>&1`  
    If you use `Queue::work`, run that in a separate cron or long-running process if the host allows.

### 8. Security checklist

-   `APP_DEBUG=false` and `APP_ENV=production`.
-   No `.env` in Git or public folder.
-   Keep `vendor/`, `.env`, and project root **above** or outside the web document root when possible; only `public` (or `public_html` contents) should be web-accessible.
-   Use HTTPS and set `APP_URL` to `https://...`.

---

**Summary:** Build assets locally, upload the app (with `vendor` if no SSH), create `.env` and run migrations/caches, then point the site’s document root at Laravel’s `public` directory (or copy its contents into `public_html` and fix paths in `index.php`).
