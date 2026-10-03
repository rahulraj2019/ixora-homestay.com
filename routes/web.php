<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\BlockItemController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\NearbyPlaceController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\SeoRedirectController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SiteImageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');

// Temporary SMTP test — REMOVE after verifying mail. Must stay ABOVE /{slug}.
Route::get('/test-mail', function (\Illuminate\Http\Request $request) {
    $to = $request->string('to')->toString();
    if ($to === '' || ! filter_var($to, FILTER_VALIDATE_EMAIL)) {
        $to = (string) (setting('email') ?: config('mail.from.address') ?: 'admin@ixora.test');
    }

    $report = [
        'ok' => false,
        'message' => '',
        'to' => $to,
        'mailer' => config('mail.default'),
        'host' => config('mail.mailers.smtp.host'),
        'port' => config('mail.mailers.smtp.port'),
        'encryption' => config('mail.mailers.smtp.encryption') ?? config('mail.mailers.smtp.scheme'),
        'username' => config('mail.mailers.smtp.username'),
        'password_set' => filled(config('mail.mailers.smtp.password')),
        'from_address' => config('mail.from.address'),
        'from_name' => config('mail.from.name'),
        'error' => null,
        'error_class' => null,
        'hint' => null,
    ];

    try {
        if (! $report['password_set'] && $report['mailer'] === 'smtp') {
            throw new RuntimeException('MAIL_PASSWORD is empty in .env — SMTP auth will fail.');
        }

        Mail::raw('IXORA mail test at '.now()->toDateTimeString()."\n\nIf you received this, SMTP is working.", function ($message) use ($to) {
            $message->to($to)->subject('IXORA Laravel Mail Test');
        });

        $report['ok'] = true;
        $report['message'] = 'Mail sent successfully. Check inbox/spam for '.$to;
    } catch (\Throwable $e) {
        $report['message'] = 'Mail sending failed';
        $report['error'] = $e->getMessage();
        $report['error_class'] = $e::class;
        $report['previous'] = $e->getPrevious()?->getMessage();

        $msg = strtolower($e->getMessage());
        if (str_contains($msg, 'password is empty') || str_contains($msg, 'mail_password')) {
            $report['hint'] = 'Set MAIL_PASSWORD in .env, then run: php artisan config:clear';
        } elseif (str_contains($msg, 'authentication') || str_contains($msg, '535')) {
            $report['hint'] = 'SMTP auth failed — check MAIL_USERNAME / MAIL_PASSWORD, then: php artisan config:clear';
        } elseif (str_contains($msg, 'getaddrinfo') || str_contains($msg, 'could not be established')) {
            $report['hint'] = 'Cannot reach SMTP host — confirm MAIL_HOST (e.g. smtp.hostinger.com), port 587, encryption tls';
        } elseif (str_contains($msg, 'timed out')) {
            $report['hint'] = 'Connection timed out — try MAIL_PORT=465 with MAIL_ENCRYPTION=ssl';
        } else {
            $report['hint'] = 'Run: php artisan optimize:clear';
        }
    }

    $status = $report['ok'] ? 200 : 500;
    $title = $report['ok'] ? 'Mail OK' : 'Mail FAILED';
    $color = $report['ok'] ? '#166534' : '#991b1b';
    $bg = $report['ok'] ? '#ecfdf5' : '#fef2f2';

    $rows = '';
    foreach ($report as $key => $value) {
        if ($value === null || $value === '') {
            continue;
        }
        if (is_bool($value)) {
            $value = $value ? 'yes' : 'no';
        }
        $rows .= '<tr><th>'.e((string) $key).'</th><td>'.e((string) $value).'</td></tr>';
    }

    $hintHtml = $report['hint']
        ? '<div class="hint"><strong>Hint:</strong> '.e($report['hint']).'</div>'
        : '';

    $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{$title} — IXORA Mail Test</title>
  <style>
    body{font-family:system-ui,sans-serif;background:#f8fafc;margin:0;padding:24px;color:#0f172a}
    .card{max-width:720px;margin:0 auto;background:#fff;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden}
    .head{padding:20px 24px;background:{$bg};color:{$color};font-size:22px;font-weight:700}
    .body{padding:20px 24px}
    table{width:100%;border-collapse:collapse}
    th,td{text-align:left;vertical-align:top;padding:10px 0;border-bottom:1px solid #f1f5f9;font-size:14px}
    th{width:160px;color:#64748b;font-weight:600}
    .hint{margin-top:16px;padding:12px 14px;border-radius:10px;background:#fff7ed;color:#9a3412;font-size:14px}
    code{background:#f1f5f9;padding:2px 6px;border-radius:6px}
  </style>
</head>
<body>
  <div class="card">
    <div class="head">{$title}</div>
    <div class="body">
      <p>Open <code>/test-mail?to=rahulraj.pentagon@gmail.com</code> to send to another address.</p>
      <table>{$rows}</table>
      {$hintHtml}
    </div>
  </div>
</body>
</html>
HTML;

    return response($html, $status)->header('Content-Type', 'text/html; charset=UTF-8');
})->middleware('throttle:5,1');


Route::post('/booking', [BookingController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('booking.store');

Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('contact.store');

Route::get('/api/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/api/reviews', [ReviewController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('reviews.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->middleware('throttle:10,1')->name('login.submit');

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('pages', AdminPageController::class)->except(['show']);
        Route::post('pages/{page}/blocks', [AdminPageController::class, 'storeBlock'])->name('pages.blocks.store');
        Route::put('blocks/{block}', [AdminPageController::class, 'updateBlock'])->name('blocks.update');
        Route::delete('blocks/{block}', [AdminPageController::class, 'destroyBlock'])->name('blocks.destroy');
        Route::post('pages/{page}/blocks/reorder', [AdminPageController::class, 'reorderBlocks'])->name('pages.blocks.reorder');

        Route::post('blocks/{block}/items', [BlockItemController::class, 'store'])->name('block-items.store');
        Route::put('block-items/{item}', [BlockItemController::class, 'update'])->name('block-items.update');
        Route::delete('block-items/{item}', [BlockItemController::class, 'destroy'])->name('block-items.destroy');
        Route::post('block-items/{item}/duplicate', [BlockItemController::class, 'duplicate'])->name('block-items.duplicate');

        Route::get('bookings/export', [AdminBookingController::class, 'export'])->name('bookings.export');
        Route::patch('bookings/{booking}/quick', [AdminBookingController::class, 'quickUpdate'])->name('bookings.quick');
        Route::resource('bookings', AdminBookingController::class)->except(['create', 'store']);

        Route::get('media', [MediaController::class, 'index'])->name('media.index');
        Route::post('media', [MediaController::class, 'store'])->name('media.store');
        Route::put('media/{medium}', [MediaController::class, 'update'])->name('media.update');
        Route::delete('media/{medium}', [MediaController::class, 'destroy'])->name('media.destroy');

        Route::get('site-images', [SiteImageController::class, 'index'])->name('site-images.index');
        Route::put('site-images', [SiteImageController::class, 'update'])->name('site-images.update');

        Route::get('nearby-places', [NearbyPlaceController::class, 'index'])->name('nearby-places.index');
        Route::put('nearby-places', [NearbyPlaceController::class, 'update'])->name('nearby-places.update');

        Route::get('enquiries', [EnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('enquiries/{enquiry}', [EnquiryController::class, 'show'])->name('enquiries.show');
        Route::put('enquiries/{enquiry}', [EnquiryController::class, 'update'])->name('enquiries.update');
        Route::delete('enquiries/{enquiry}', [EnquiryController::class, 'destroy'])->name('enquiries.destroy');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

        Route::get('seo/redirects', [SeoRedirectController::class, 'index'])->name('seo.redirects');
        Route::post('seo/redirects', [SeoRedirectController::class, 'store'])->name('seo.redirects.store');
        Route::put('seo/redirects/{redirect}', [SeoRedirectController::class, 'update'])->name('seo.redirects.update');
        Route::delete('seo/redirects/{redirect}', [SeoRedirectController::class, 'destroy'])->name('seo.redirects.destroy');

        Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
        Route::put('reviews/{review}', [AdminReviewController::class, 'update'])->name('reviews.update');
        Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::resource('faqs', AdminFaqController::class)->except(['show']);

        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('activity', [ActivityLogController::class, 'index'])->name('activity.index');
    });
});

Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '^(?!admin|api|storage|assets|test|test-mail|up).*$')
    ->name('page.show');
