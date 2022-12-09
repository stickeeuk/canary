<?php

namespace App\Commands;

class FixCommand extends ToolCommand
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'fix
                            {args?*      : Arguements to pass through}
                            {--options=* : Options to pass through}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'PHP CS Fixer';

    protected string $toolName = 'php-cs-fixer';

    protected string $command = 'fix';
}
