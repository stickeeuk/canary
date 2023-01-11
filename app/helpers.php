<?php

declare(strict_types=1);

if (! function_exists('vendor_path')) {
    function vendor_path(string $path = ''): string
    {
        if (! empty($GLOBALS['_composer_bin_dir'])) {
            $vendorPath = $GLOBALS['_composer_bin_dir'] . DIRECTORY_SEPARATOR;
            $vendorPath = str_replace(DIRECTORY_SEPARATOR . 'bin', '', $vendorPath);
        } else {
            $vendorPath = base_path(DIRECTORY_SEPARATOR . 'vendor');
        }

        return $path !== '' && $path !== '0'
            ? $vendorPath . DIRECTORY_SEPARATOR . $path
            : $vendorPath;
    }
}
