<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Storage;

beforeEach(function() {
    $fileName = '.php-cs-fixer.cache';
    Storage::disk('cwd')->move($fileName, "{$fileName}.old");
});

afterEach(function() {
    $fileName = '.php-cs-fixer.cache';
    Storage::disk('cwd')->move("{$fileName}.old", $fileName);
});

it('works', function () {
    $this->artisan('fix')
        ->expectsOutputToContain('Fixed all files')
        ->assertExitCode(0);
});

it('allows passing options', function () {
    $this->artisan('fix --dry-run')
        ->expectsOutputToContain('Checked all files')
        ->assertExitCode(0);
});
