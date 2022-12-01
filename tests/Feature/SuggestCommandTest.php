<?php

it('works', function () {
    $this->artisan('suggest config/app.php')
        ->expectsOutputToContain('[OK] Rector is done!')
        ->assertExitCode(0);
});

it('allows passing options', function () {
    $this->artisan('suggest --help')
        ->expectsOutputToContain('Display help for the given command')
        ->assertExitCode(0);
});
