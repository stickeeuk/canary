<?php

if (! function_exists('vendor_path')) {
    function vendor_path(string $path = ''): string {
        $vendorPath = $_composer_bin_dir ?? __DIR__ . '/../vendor/bin';
        $vendorPath = str_replace(DIRECTORY_SEPARATOR . 'bin', '', $vendorPath);

        return $path
            ? $vendorPath . DIRECTORY_SEPARATOR . $path
            : $vendorPath;
    }
}

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
            'root' => vendor_path()
        ]
    ],
];
