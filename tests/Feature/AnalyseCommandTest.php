<?php

declare(strict_types=1);

it('works', function () {
    $path = base_path('tests/Fixtures/GoodCode.php');
    $this->artisan('analyse ' . $path)
        ->expectsOutputToContain('No errors')
        ->assertExitCode(0);
});

it('allows passing options', function () {
    $this->artisan('analyse -h')
        ->expectsOutputToContain('Display help for the given command')
        ->assertExitCode(0);
});
