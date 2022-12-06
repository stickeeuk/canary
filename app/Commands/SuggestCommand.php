<?php

namespace App\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

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
    protected $description = 'runs Rector in --dry-run mode';

    protected string $path = 'vendor/bin/rector';

    protected string $command = 'process';

    protected ?string $alias = 'suggest';

    protected array $commandOptions = ['--dry-run'];

    protected string $failedCommandTaskTitle = 'no suggestions could be made';

    protected function taskReportsFailure(Process $process): bool
    {
        return Str::of($process->getOutput())
            ->contains('would have changed (dry-run) by Rector');
    }
}
