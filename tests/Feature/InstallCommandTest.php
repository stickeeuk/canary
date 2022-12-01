<?php

use Illuminate\Support\Facades\Storage;

it('works', function () {
    $this->artisan('install')->assertExitCode(0);
});

it('copies vendor files', function () {
    $this->artisan('install');

    $this->assertFileExists('.php-cs-fixer.dist.php');
});

it('copies local files', function () {
    $this->artisan('install');

    $this->assertFileExists('.husky/pre-commit');
    $this->assertStringContainsString(
        'npx lint-staged',
        Storage::disk('cwd')->get('.husky/pre-commit')
    );
});

it('works in a custom directory', function () {
    $directory = 'customDirectory';
    $disk = Storage::disk('cwd');

    $disk->makeDirectory($directory);
    $disk->put($directory . DIRECTORY_SEPARATOR . '.gitignore', '');

    $this->artisan("install {$directory}")
        ->assertExitCode(0);

    $this->assertFileExists($directory . DIRECTORY_SEPARATOR . '.php-cs-fixer.dist.php');

    // tidy up
    $disk->deleteDirectory($directory);
});

it('requires a .gitignore to install', function () {
    $directory = 'customDirectory';
    $disk = Storage::disk('cwd');

    $disk->makeDirectory($directory);

    $this->artisan("install {$directory}")
        ->assertExitCode(1);

    // tidy up
    $disk->deleteDirectory($directory);
});

it('updates the .gitignore', function () {
    $directory = 'customDirectory';
    $gitignore = '.gitignore';
    $disk = Storage::disk('cwd');

    $disk->makeDirectory($directory);
    $disk->put($directory . DIRECTORY_SEPARATOR . $gitignore, '');

    $this->artisan("install {$directory}");

    $this->assertStringContainsString(
        '.php-cs-fixer.cache',
        Storage::disk('cwd')->get($directory . DIRECTORY_SEPARATOR . $gitignore)
    );

    // tidy up
    $disk->deleteDirectory($directory);
});
