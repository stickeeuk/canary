<?php

declare(strict_types=1);

use Stickee\Canary\Commands\InstallCommand;
use Stickee\Canary\Commands\ToolCommand;

arch()->preset()->php();
arch()->preset()->laravel();
arch()->preset()->security();

arch()
    ->expect('Stickee\Canary')
    ->toUseStrictEquality()
    ->toUseStrictTypes();

arch('canary commands should extend the tool command class')
    ->expect('Stickee\Canary\Commands')
    ->classes()
    ->toHaveSuffix('Command')
    ->toExtend(ToolCommand::class)
    ->ignoring([InstallCommand::class, ToolCommand::class]);
