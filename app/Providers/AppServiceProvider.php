<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // @codeCoverageIgnoreStart
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
    // @codeCoverageIgnoreEnd

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
