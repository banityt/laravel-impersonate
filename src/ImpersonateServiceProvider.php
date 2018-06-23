<?php

namespace BaniTo\Impersonate;

use Illuminate\Support\ServiceProvider;

class ImpersonateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishConfig();
    }

    public function register()
    {
        $this->mergeConfig();
        $this->registerManager();
    }

    public function publishConfig()
    {
        $this->publishes([
            __DIR__ . '/../config/impersonate.php' => config_path('impersonate.php'),
        ], 'impersonate');
    }

    public function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/impersonate.php', 'impersonate'
        );
    }

    public function registerManager()
    {
        $this->app->singleton(ImpersonateManager::class, function () {
            return new ImpersonateManager();
        });
    }
}