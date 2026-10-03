# Live deploy checklist (IXORA)

## 1. `.env` on live (critical)

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ixora-homestay.com
ASSET_URL=
APP_KEY=...          # php artisan key:generate
DB_*=...             # live MySQL
MAIL_MAILER=smtp
MAIL_HOST=smtp.your-host.com
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ixora-homestay.com
MAIL_FROM_NAME="IXORA Homestay"
SESSION_SECURE_COOKIE=true
LOG_LEVEL=error
BOOST_ENABLED=false
```

**Never leave `MAIL_MAILER=log` on live** — that only writes emails to `storage/logs` and never reaches inboxes.

**Never leave `APP_DEBUG=true` on live.** It injects Laravel Boost browser-logger JS (shows in Google Search Console HTML) and is a security risk.

After deploy, in **Admin → Settings → Email notifications**, set a real **Primary admin email** (and optional additional addresses). Booking and enquiry alerts go there.

## 2. Composer on live

```bash
composer install --no-dev --optimize-autoloader
```

Do **not** install `laravel/boost` on production (`--no-dev` skips it).

## 3. After upload

```bash
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 4. Google Search Console screenshot

If the screenshot looks like **header + black empty area**:

1. Confirm live CSS is `style.css?v=28` or newer (hero content starts near the top on mobile).
2. Confirm `APP_DEBUG=false` and no `browser-logger-active` in page HTML.
3. Search Console → URL Inspection → Test live URL → Request indexing.

## 5. Files that affect GSC / mobile

- `public/assets/css/style.css`
- `resources/views/layouts/app.blade.php` (CSS `?v=` cache bump)
- Live `.env` (`APP_DEBUG`, `APP_ENV`)
