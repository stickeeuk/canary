<?php

declare(strict_types=1);

namespace App\Commands;

class AnalyseCommand extends ToolCommand
{
    protected $signature = 'analyse
                            {args?*      : Arguments to pass through}
                            {--options=* : Options to pass through}';

    protected $description = 'PHPStan';

    protected string $toolName = 'phpstan';

    protected string $command = 'analyse';
}
