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

it('will prevent performance issues around xdebug by passing in a specific option', function (): void {
    if (! extension_loaded('xdebug')) {
        $this::markTestSkipped('Xdebug is not installed or activated!');
    }

    $this
        ->artisan('analyse')
        ->doesntExpectOutputToContain('The Xdebug PHP extension is active, but "--xdebug" is not used');
});
