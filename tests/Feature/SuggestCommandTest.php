<?php

use Illuminate\Support\Facades\Storage;

it('works', function () {
    $this->artisan('suggest config/app.php')
        ->expectsOutputToContain('[OK] Rector is done!')
        ->assertSuccessful();
});

it('allows passing options', function () {
    $this->artisan('suggest --help')
        ->expectsOutputToContain('Display help for the given command')
        ->assertSuccessful();
});

it('suggests improvements on bad code', function () {
    $badCode = <<<'EOF'
        <?php
        class BadCode
        {
            public function example(): void
            {
                return true;
            }
        }
        EOF;

    $path = 'BadCode.php';
    $storagePath = storage_path('app' . DIRECTORY_SEPARATOR . $path);
    // create temporary file to process
    Storage::put($path, $badCode);

    $this->artisan("suggest {$storagePath}")
        ->expectsOutputToContain('public function example(): bool')
        ->assertFailed();

    // tidy up temporary file
    Storage::delete($path);
});
