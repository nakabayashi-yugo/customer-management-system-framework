<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route; // ← これ追加

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(Kernel $kernel): void
    {
        $kernel->appendMiddlewareToGroup('web', VerifyCsrfToken::class);
    }
}
