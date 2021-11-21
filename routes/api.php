<?php

use Hridoy\LaravelUserGuide\Http\Controllers\UserGuideCategoryController;
use Hridoy\LaravelUserGuide\Http\Controllers\UserGuideController;
use Illuminate\Support\Facades\Route;

$routePrefix = config('user_guide.route.prefix');
$routeGuard = config('user_guide.route.guard');

$groupRules = [];
if ($routePrefix) {
    $groupRules['prefix'] = $routePrefix;
}
if ($routeGuard) {
    $groupRules['middleware'] = $routeGuard;
}

Route::group($groupRules, function () {
    Route::apiResource('user-guide-categories', UserGuideCategoryController::class);
    Route::apiResource('user-guides', UserGuideController::class);
});
