<?php

namespace Hridoy\LaravelUserGuide;

use Illuminate\Support\ServiceProvider;

class LaravelUserGuideServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/user_guide.php' => config_path('user_guide.php')
        ], 'user-guide');

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/user_guide.php', 'user_guide'
        );
    }
}
