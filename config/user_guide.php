<?php

return [
    'route' => [
        'prefix' => 'api',
        'guard' => 'auth:sanctum'
    ],
    'photo' => [
        'disk' => 'do',
        'path' => 'user-guides'
    ],
    'video' => [
        'source' => 'youtube'
    ],
    'user-guide-category-permissions' => [
        'enabled' => false,
        'index' => 'view any user guide category',
        'store' => 'create user guide category',
        'show' => 'view user guide category',
        'update' => 'edit user guide category',
        'destroy' => 'delete user guide category',
        'restore' => 'restore user guide category',
        'forceDelete' => 'force delete user guide category'
    ],
    'user-guide-permissions' => [
        'enabled' => false,
        'index' => 'view any user guide',
        'store' => 'create user guide',
        'show' => 'view user guide',
        'update' => 'edit user guide',
        'destroy' => 'delete user guide',
        'restore' => 'restore user guide',
        'forceDelete' => 'force delete user guide'
    ],
];
