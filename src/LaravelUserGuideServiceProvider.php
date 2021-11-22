<?php

namespace Hridoy\LaravelUserGuide;

use Hridoy\LaravelUserGuide\Models\UserGuide;
use Hridoy\LaravelUserGuide\Policies\UserGuidePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class LaravelUserGuideServiceProvider extends ServiceProvider
{
    protected $policies = [
        UserGuide::class => UserGuidePolicy::class
    ];

    public function boot()
    {
        $this->offerPublishing();
        $this->registerPolicies();

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/user_guide.php', 'user_guide'
        );
    }

    public function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    protected function offerPublishing()
    {
        $this->publishes([
            __DIR__ . '/../config/user_guide.php' => config_path('user_guide.php')
        ], 'config');
    }
}
