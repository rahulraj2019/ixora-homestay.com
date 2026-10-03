# IXORA Homestay — Laravel CMS

Production-ready Laravel + MySQL CMS using the IXORA frontend template.

## Local XAMPP setup

1. Ensure Apache uses **PHP 8.4+** (Laravel 13 requirement).
2. Database `home_db` must exist (MySQL/MariaDB).
3. From project root:

```bash
composer install
copy .env.example .env   # if needed
php artisan key:generate
# Configure .env: DB_DATABASE=home_db, APP_URL=http://localhost/Home
php artisan migrate --seed
php artisan storage:link
```

The project root `.htaccess` rewrites into `public/` so URLs do **not** need `/public`.

4. Open: `http://localhost/Home`
5. Admin: `http://localhost/Home/admin/login`

### Default admin

- Email: `admin@ixora.test`
- Password: `password`
- Role: `super_admin`

**Change this password immediately after first login.**

## Mail SMTP (.env)

```
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

Booking notification recipients are configured in **Admin → Settings** (not hard-coded).

## Queues (optional)

```
QUEUE_CONNECTION=database
php artisan queue:work
```

Mailables can be queued later; currently sent synchronously with try/catch so bookings always save.

## Scheduler / cron

```
* * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
```

## Storage permissions

Ensure `storage/` and `bootstrap/cache/` are writable by the web server.

```
php artisan storage:link
```

## Production checklist

See **[DEPLOYMENT.md](DEPLOYMENT.md)** for the full local → live guide (env changes, migrations, Media Library / Site Images, FAQs, adults/children booking, smoke tests).

Short checklist:

- [ ] `APP_ENV=production`
- [ ] `APP_DEBUG=false`
- [ ] Strong `APP_KEY`
- [ ] HTTPS `APP_URL`
- [ ] SMTP configured
- [ ] Admin password changed
- [ ] `php artisan migrate --force`
- [ ] `php artisan storage:link`
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `php artisan view:cache`
- [ ] Document root points to `/public`
- [ ] `/admin` blocked from indexing via robots.txt

## SEO checklist

- [ ] Unique meta title/description per page (Admin → Pages)
- [ ] Canonical URLs set where needed
- [ ] OG/Twitter images
- [ ] `/sitemap.xml` reachable
- [ ] `/robots.txt` references sitemap
- [ ] Image alt text in Media Library
- [ ] 301 redirects for changed slugs

## Testing checklist

- [ ] Frontend pages load on mobile/desktop
- [ ] Admin login / logout
- [ ] Page create/edit/delete
- [ ] Block + item CRUD
- [ ] Media upload
- [ ] Booking submit → DB row + emails
- [ ] Booking status update
- [ ] Contact enquiry
- [ ] Reviews approve
- [ ] Sitemap / robots
- [ ] Unauthorized `/admin` access blocked
