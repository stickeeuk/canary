<?php

declare(strict_types=1);

namespace Stickee\Canary\Commands;

class FixCommand extends ToolCommand
{
    /** @var string */
    protected $signature = 'fix
                            {args?*      : Arguments to pass through}
                            {--options=* : Options to pass through}';

    /** @var string */
    protected $description = 'PHP CS Fixer';

    protected string $toolName = 'php-cs-fixer';

    protected string $command = 'fix';
}
