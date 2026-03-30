<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->registered(function ($app) {
        /**
         * Perbaikan Khusus Vercel:
         * Memaksa Laravel menggunakan folder /tmp untuk menyimpan file framework
         * karena folder storage bawaan Vercel tidak bisa ditulis (read-only).
         */
        if (config('app.env') === 'production' || isset($_SERVER['VERCEL_URL'])) {
            $app->useStoragePath('/tmp/storage');

            // Pastikan folder-folder penting dibuat di folder sementara (/tmp)
            $commonFolders = [
                '/tmp/storage/framework/views',
                '/tmp/storage/framework/cache',
                '/tmp/storage/framework/sessions',
                '/tmp/storage/bootstrap/cache',
            ];

            foreach ($commonFolders as $folder) {
                if (!is_dir($folder)) {
                    mkdir($folder, 0755, true);
                }
            }

            // Arahkan lokasi compile view ke folder /tmp
            config(['view.compiled' => '/tmp/storage/framework/views']);
        }
    })
    ->create();