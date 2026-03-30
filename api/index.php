<?php
// Autoload
require __DIR__ . '/../vendor/autoload.php';

// Boot Application
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Paksa pembersihan cache di memori untuk Vercel
$app->forgetInstance('config');
$app->make('config');

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();
$kernel->terminate($request, $response);