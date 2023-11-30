<?php

declare(strict_types=1);

namespace App\Commands;

use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Process\Process;

abstract class ToolCommand extends Command
{
    protected string $toolName;

    protected string $command;

    protected ?string $alias = null;

    protected string $failedCommandTaskTitle = 'task failed';

    protected array $commandOptions = [];

    protected bool $postFix = false;

    public function __construct()
    {
        parent::__construct();
        $this->ignoreValidationErrors(); // Allows passing dynamic args and options through.
    }

    public function handle(): int
    {
        if (! $this->alias) {
            $this->alias = $this->command;
        }

        $args = $this->input->getArguments()['args'];

        $command = array_merge(
            [$this->toolPath(), $this->command],
            $this->commandOptions,
            $args,
            array_unique([
                ...$this->getDynamicOptions(),
                ...$this->commandSpecificOptions(),
            ]),
        );

        /*
         * Some commands report exit code 1, even if the command itself ran OK. Commands that run 'git diff' do this
         * for CI to report an 'error', because a diff is present.
         */
        $commandReportsFailure = false;

        $taskName = trim(
            Str::replace(
                search: $this->vendorBinPath(),
                replace: '',
                subject: implode(' ', $command),
            )
        );

        $success = $this->task($taskName, function () use ($command, &$commandReportsFailure) {
            $task = $this->process($command);

            if ($task['reportsFailure']) {
                $commandReportsFailure = true;
            }

            return $task['success'];
        }, 'in progress');

        if ($commandReportsFailure) {
            $this->task($this->failedCommandTaskTitle, static fn(): bool => false);

            return 1;
        }

        if (! $success) {
            return 1;
        }

        if ($this->postFix) {
            $this->call('fix', ['args' => $args]);
        }

        return 0;
    }

    /**
     * Returns additional options to be passed into a command, specific to that particular command.
     *
     * @return array<int, string>
     */
    protected function commandSpecificOptions(): array
    {
        return [];
    }

    protected function taskReportsFailure(Process $process): bool
    {
        return false;
    }

    private function toolPath(): string
    {
        return $this->vendorBinPath() . $this->toolName;
    }

    private function vendorBinPath(): string
    {
        return vendor_path('bin' . DIRECTORY_SEPARATOR);
    }

    /** @return array{success: bool, reportsFailure: bool} */
    private function process(array $command): array
    {
        $process = new Process($command);
        $process->setTimeout(300);
        $process->run();

        $taskFailedSuccessfully = $this->taskReportsFailure($process);

        if (! $process->isSuccessful() && ! $taskFailedSuccessfully) {
            $taskSuccess = false;
            $output = $process->getErrorOutput();
            $stdOut = $process->getOutput();

            if ($stdOut !== '' && $stdOut !== '0') {
                $output .= PHP_EOL;
                $output .= $stdOut;
            }
        } else {
            $taskSuccess = true;
            $output = $process->getErrorOutput();
            $output .= $process->getOutput();
        }

        $this->newLine();
        $this->line($output);

        return [
            'success' => $taskSuccess,
            'reportsFailure' => $taskFailedSuccessfully,
        ];
    }

    /** @return array<int, string> */
    private function getDynamicOptions(): array
    {
        $input = $this->input->__toString();
        $options = [];

        foreach (explode(' ', $input) as $string) {
            if ($string === '--') {
                return $options;
            }

            if ($this->isOption($string)) {
                $options[] = $string;
            }
        }

        return $options;
    }

    private function isOption(string $string): bool
    {
        if ($string === '') {
            return false;
        }

        return Str::startsWith($string, '--')
            || (
                $string[0] === '-'
                && $string !== '-'
            );
    }
}
