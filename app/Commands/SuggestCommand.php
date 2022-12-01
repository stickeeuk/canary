<?php

namespace App\Commands;

class SuggestCommand extends ToolCommand
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'suggest
                            {args?*      : Arguements to pass through}
                            {--options=* : Options to pass through}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Rector';

    protected string $path = 'vendor/bin/rector';

    protected string $command = 'process';

    protected ?string $alias = 'suggest';

    protected array $commandOptions = ['--dry-run'];
}
