<?php

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
