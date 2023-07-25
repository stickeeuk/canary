<?php

declare(strict_types=1);

it('works', function () {
    $this->artisan('analyse')
        ->expectsOutputToContain('No errors')
        ->assertExitCode(0);
});

it('allows passing options', function () {
    $this->artisan('analyse -h')
        ->expectsOutputToContain('Display help for the given command')
        ->assertExitCode(0);
});
