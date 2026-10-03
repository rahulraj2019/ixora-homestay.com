<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
| When the project-root .htaccess rewrites into /public without /public in the
| browser URL, Apache still reports SCRIPT_NAME under /public. That makes Laravel
| treat the base path as /{app}/public, so /admin and other routes 404.
| Align SCRIPT_NAME with the public URL when /public is not in the request path.
*/
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?: '';

if (
    str_ends_with($scriptName, '/public/index.php')
    && ! str_contains($requestPath, '/public/')
    && ! str_ends_with($requestPath, '/public')
) {
    $_SERVER['SCRIPT_NAME'] = substr($scriptName, 0, -strlen('/public/index.php')).'/index.php';

    if (isset($_SERVER['PHP_SELF']) && str_ends_with($_SERVER['PHP_SELF'], '/public/index.php')) {
        $_SERVER['PHP_SELF'] = substr($_SERVER['PHP_SELF'], 0, -strlen('/public/index.php')).'/index.php';
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
