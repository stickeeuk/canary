<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $fileName = '.php-cs-fixer.cache';
    Storage::disk('cwd')->move($fileName, "{$fileName}.old");
});

afterEach(function () {
    $fileName = '.php-cs-fixer.cache';
    Storage::disk('cwd')->move("{$fileName}.old", $fileName);
});

it('works', function () {
    $this->artisan('fix')
        ->expectsOutputToContain('stickee')
        ->assertExitCode(0);
});

it('allows passing options', function () {
    $this->artisan('fix -- --help')
        ->expectsOutputToContain('Exit code of the `fix` command is built using following bit flags:')
        ->assertExitCode(0);
});
