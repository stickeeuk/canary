<?php

declare(strict_types=1);

namespace App\Commands;

class ImproveCommand extends ToolCommand
{
    protected $signature = 'improve
                            {args?*      : Arguments to pass through}
                            {--options=* : Options to pass through}';

    protected $description = 'Rector';

    protected string $toolName = 'rector';

    protected string $command = 'process';

    protected ?string $alias = 'improve';

    protected bool $postFix = true;
}
