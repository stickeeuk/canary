<?php

declare(strict_types=1);

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
    $storagePath = base_path('tests/Fixtures/BadCode.php');

    $this->artisan("suggest {$storagePath}")
        ->expectsOutputToContain('public function run(): int')
        ->assertFailed();
});
