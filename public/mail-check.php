<?php

/**
 * Temporary Hostinger mail diagnostic.
 * Upload to: public/mail-check.php
 * Open: https://ixora-homestay.com/mail-check.php
 * DELETE this file after testing.
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$report = [
    'ok' => false,
    'file' => __FILE__,
    'time' => date('c'),
];

try {
    require __DIR__.'/../vendor/autoload.php';
    $app = require __DIR__.'/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    $report['app_env'] = config('app.env');
    $report['app_url'] = config('app.url');
    $report['base_path'] = base_path();
    $report['mailer'] = config('mail.default');
    $report['host'] = config('mail.mailers.smtp.host');
    $report['port'] = config('mail.mailers.smtp.port');
    $report['encryption'] = config('mail.mailers.smtp.encryption') ?? config('mail.mailers.smtp.scheme');
    $report['username'] = config('mail.mailers.smtp.username');
    $report['password_set'] = filled(config('mail.mailers.smtp.password'));
    $report['password_length'] = strlen((string) config('mail.mailers.smtp.password'));
    $report['from_address'] = config('mail.from.address');
    $report['from_name'] = config('mail.from.name');

    $routesFile = base_path('routes/web.php');
    $report['web_php_exists'] = is_file($routesFile);
    $report['web_php_has_test_mail'] = is_file($routesFile)
        && str_contains((string) file_get_contents($routesFile), "test-mail");
    $report['route_cache_exists'] = is_file(base_path('bootstrap/cache/routes-v7.php'))
        || is_file(base_path('bootstrap/cache/routes.php'));

    try {
        $report['route_registered'] = collect(Illuminate\Support\Facades\Route::getRoutes()->getRoutes())
            ->contains(fn ($route) => trim($route->uri(), '/') === 'test-mail');
    } catch (Throwable $e) {
        $report['route_registered'] = false;
        $report['route_registered_error'] = $e->getMessage();
    }

    $to = 'rahulraj.pentagon@gmail.com';
    $report['to'] = $to;

    Illuminate\Support\Facades\Mail::raw(
        'IXORA public/mail-check.php diagnostic at '.now()->toDateTimeString(),
        function ($message) use ($to) {
            $message->to($to)->subject('IXORA Mail Check (public script)');
        }
    );

    $report['ok'] = true;
    $report['message'] = 'Mail sent successfully! Check inbox/spam for '.$to;
} catch (Throwable $e) {
    $report['message'] = 'Failed';
    $report['error'] = $e->getMessage();
    $report['error_class'] = $e::class;
    $report['error_file'] = $e->getFile();
    $report['error_line'] = $e->getLine();
    $report['previous'] = $e->getPrevious()?->getMessage();

    $msg = strtolower($e->getMessage());
    if (str_contains($msg, 'authentication') || str_contains($msg, '535')) {
        $report['hint'] = 'Wrong MAIL_USERNAME or MAIL_PASSWORD. Fix .env then: php artisan config:clear';
    } elseif (str_contains($msg, 'getaddrinfo') || str_contains($msg, 'could not be established')) {
        $report['hint'] = 'SMTP host unreachable. Use smtp.hostinger.com port 587 tls.';
    } elseif (str_contains($msg, 'timed out')) {
        $report['hint'] = 'Timeout. Try MAIL_PORT=465 and MAIL_ENCRYPTION=ssl.';
    } else {
        $report['hint'] = 'Read error above. Also run: php artisan optimize:clear';
    }
}

http_response_code($report['ok'] ? 200 : 500);
echo json_encode($report, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
