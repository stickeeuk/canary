<?php

declare(strict_types=1);

namespace Stickee\Canary\Commands;

class AnalyseCommand extends ToolCommand
{
    /** @var string */
    protected $signature = 'analyse
                            {args?*      : Arguments to pass through}
                            {--options=* : Options to pass through}';

    /** @var string */
    protected $description = 'PHPStan';

    protected string $toolName = 'phpstan';

    protected string $command = 'analyse';
}
