<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Storage;

$requiredFiles = [
    '.github/workflows/php.yaml',
    '.husky/pre-commit',
    '.php-cs-fixer.dist.php',
    '.php-cs-fixer.cache',
    '.lintstagedrc.json',
    'phpstan.ci.neon',
    'phpstan.dist.neon',
    'rector.php',
];

beforeEach(function () use ($requiredFiles) {
    foreach ($requiredFiles as $file) {
        Storage::disk('cwd')->move($file, "{$file}.old");
    }
});

afterEach(function () use ($requiredFiles) {
    foreach ($requiredFiles as $file) {
        Storage::disk('cwd')->move("{$file}.old", $file);
    }
});

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

it('overwrites copied GitHub workflow with its own', function () {
    $this->artisan('install');

    $file = '.github/workflows/php.yaml';

    $this->assertFileExists($file);

    $contents = Storage::disk('cwd')->get($file);

    $this->assertStringContainsString('php-stan', $contents);
    $this->assertStringContainsString('php-cs-fixer', $contents);
});

it('works in a custom directory', function () {
    $directory = 'customDirectory';
    $disk = Storage::disk('cwd');

    $disk->makeDirectory($directory);
    $disk->put($directory . DIRECTORY_SEPARATOR . '.gitignore', '');

    $this->artisan("install {$directory}")
        ->assertExitCode(0);

    $this->assertFileExists($directory . DIRECTORY_SEPARATOR . '.php-cs-fixer.dist.php');

    // Tidy up.
    $disk->deleteDirectory($directory);
});

it('requires a .gitignore to install', function () {
    $directory = 'customDirectory';
    $disk = Storage::disk('cwd');

    $disk->makeDirectory($directory);

    $this->artisan("install {$directory}")
        ->assertExitCode(1);

    // Tidy up.
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

    // Tidy up.
    $disk->deleteDirectory($directory);
});

it('updates the Larastan config paths', function () {
    $this->artisan('install');

    $contents = Storage::disk('cwd')->get('phpstan.dist.neon');

    $this->assertStringContainsString(
        'tools/canary/',
        $contents
    );

    $this->assertStringNotContainsString(
        'tools/phpstan/',
        $contents
    );
});
