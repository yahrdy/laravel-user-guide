<?php

namespace Hridoy\LaravelUserGuide;

use App\Models\User;
use Hridoy\LaravelUserGuide\Models\UserGuide;
use Hridoy\LaravelUserGuide\Policies\UserGuidePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class LaravelUserGuideServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->offerPublishing();

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/user_guide.php', 'user_guide'
        );
    }

    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/user_guide.php' => config_path('user_guide.php')
        ], 'config');
    }
}
