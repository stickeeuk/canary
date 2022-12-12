<?php

declare(strict_types=1);

namespace App\Commands;

class FixCommand extends ToolCommand
{
    protected $signature = 'fix
                            {args?*      : Arguments to pass through}
                            {--options=* : Options to pass through}';

    protected $description = 'PHP CS Fixer';

    protected string $toolName = 'php-cs-fixer';

    protected string $command = 'fix';
}
