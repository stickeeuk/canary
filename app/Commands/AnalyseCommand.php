<?php

namespace App\Commands;

use function Termwind\{render};

class AnalyseCommand extends ToolCommand
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
    protected $description = 'PHPStan';

    protected string $path = 'vendor/bin/phpstan';

    protected string $command = 'analyse';
}
