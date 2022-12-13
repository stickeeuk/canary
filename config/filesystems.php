<?php

return [
    'default' => 'local',
    'disks' => [
        'cwd' => [
            'driver' => 'local',
            'root' => getcwd(),
        ],
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app')
        ],
        'vendor' => [
            'driver' => 'local',
            'root' => base_path() . '/vendor'
        ]
    ],
];
