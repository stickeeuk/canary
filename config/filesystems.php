<?php

declare(strict_types=1);

return [
    'default' => 'local',
    'disks' => [
        'cwd' => [
            'driver' => 'local',
            'root' => getcwd(),
        ],
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],
        'vendor' => [
            'driver' => 'local',
            'root' => vendor_path(),
        ],
    ],
];
