<?php

return [
    'null_color' => 'primary',

    'navigation_group_sort' => 100,

    'navigation_group' => 'System administration',

    'options_color' => [
        'primary' => 'Primary',
        'secondary' => 'Secondary',
        'warning' => 'Warning',
        'success' => 'Success',
        'danger' => 'Danger',
    ],

    'models' => [
        App\Models\ReservationVehiclePrepare::class => 'Alistamiento',
        App\Models\User::class => 'Usuarios',
    ],

    'cache_seconds' => now()->addHours(12),
];