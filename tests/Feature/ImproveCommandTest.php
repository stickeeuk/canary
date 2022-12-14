<?php

declare(strict_types=1);

it('works', function () {
    $this->artisan('improve config/app.php')
        ->expectsOutputToContain('[OK] Rector is done!')
        ->assertExitCode(0);
});

it('displays the name of the underlying tool', function () {
    $this->artisan('improve')
        ->expectsOutputToContain('rector process')
        ->assertExitCode(0);
});

it('allows passing options', function () {
    $this->artisan('improve --help')
        ->expectsOutputToContain('Display help for the given command')
        ->assertExitCode(0);
});
