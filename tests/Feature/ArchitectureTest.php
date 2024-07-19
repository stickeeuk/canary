<?php

declare(strict_types=1);

use Stickee\Canary\Commands\InstallCommand;
use Stickee\Canary\Commands\ToolCommand;

test('strict types are used in the project')
    ->expect('App')
    ->toUseStrictTypes();

test('canary commands should extend the tool command class')
    ->expect('App\Commands')
    ->classes()
    ->toExtend(ToolCommand::class)
    ->ignoring([InstallCommand::class, ToolCommand::class]);

test('there are no debugging methods present in the source code')
    ->expect(['dd', 'var_dump', 'echo', 'ray', 'die', 'exit', 'dump', 'print_r'])
    ->not()
    ->toBeUsed();
