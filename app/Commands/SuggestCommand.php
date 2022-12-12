<?php

declare(strict_types=1);

namespace App\Commands;

use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class SuggestCommand extends ToolCommand
{
    protected $signature = 'suggest
                            {args?*      : Arguments to pass through}
                            {--options=* : Options to pass through}';

    protected $description = 'Rector (--dry-run)';

    protected string $toolName = 'rector';

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
