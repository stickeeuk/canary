<?php

declare(strict_types=1);

const CUSTOM_PATH = '/custom/path/to/vendor';

test('vendor path will return the correct vendor path', function (string $path) {
    $vendorPath = vendor_path($path);

    expect($vendorPath)
        ->toContain('/vendor')
        ->unless(empty($path), function () use ($vendorPath, $path): void {
            expect($vendorPath)->toContain($path);
        });
})->with([
    'Standard Path' => '',
    'Custom Path' => CUSTOM_PATH,
]);

test('vendor path will return the correct path when the composer bin directory has been set', function () {
    $standardVendorPath = vendor_path();

    // This suffix should be automatically removed from the end of the inputted string:
    $binSuffix = DIRECTORY_SEPARATOR . 'bin';

    $GLOBALS['_composer_bin_dir'] = CUSTOM_PATH . $binSuffix;
    $modifiedVendorPath = vendor_path();

    expect($modifiedVendorPath)
        ->toContain(CUSTOM_PATH)
        ->not()->toContain($binSuffix)
        ->not()->toEqual($standardVendorPath);

    unset($GLOBALS['_composer_bin_dir']);
});
