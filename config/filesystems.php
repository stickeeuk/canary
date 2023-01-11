<?php

if (! function_exists('vendor_path')) {
    function vendor_path(string $path = ''): string {
        if (! empty($GLOBALS['_composer_bin_dir'])) {
            $vendorPath = $GLOBALS['_composer_bin_dir'] . DIRECTORY_SEPARATOR;
            $vendorPath = str_replace(DIRECTORY_SEPARATOR . 'bin', '', $vendorPath);
        } else {
            $vendorPath = base_path(DIRECTORY_SEPARATOR . 'vendor');
        }

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
