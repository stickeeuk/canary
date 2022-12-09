<?php

namespace App\Commands;

use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Process\Process;

abstract class ToolCommand extends Command
{
    /**
     * The CLI name of the original tool.
     */
    protected string $toolName;

    /**
     * The command to run.
     */
    protected string $command;

    /**
     * The alias of the command.
     */
    protected ?string $alias = null;

    /**
     * The name of the extra task if the command reports a failure
     */
    protected string $failedCommandTaskTitle = 'task failed';

    /**
     * Any options for the command;
     */
    protected array $commandOptions = [];

    /**
     * If the tool requires a fix running afterwards.
     */
    protected bool $postFix = false;

    public function __construct()
    {
        parent::__construct();
        $this->ignoreValidationErrors(); // allows passing dynamic args and options through
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $this->alias) {
            $this->alias = $this->command;
        }

        $args = $this->input->getArguments()['args'];

        $command = array_merge(
            [$this->toolPath(), $this->command],
            $this->commandOptions,
            $args,
            $this->getDynamicOptions()
        );

        // some commands report exit code 1
        // even if the command itself ran ok
        // (commands that run `git diff` do this
        //  for CI to report an "error"
        //  because a diff is present)
        $commandReportsFailure = false;

        $taskName = trim(
            str_replace(
                $this->vendorBinPath(),
                '',
                implode(' ', $command)
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
            $this->task($this->failedCommandTaskTitle, static fn (): bool => false);

            return 1;
        }

        if (! $success) {
            return 1;
        }

        if ($this->postFix) {
            $this->call('fix', ['args' => $args]);
        }
    }

    /**
     * Used to check if the underlying command reported a failure
     *
     * @param \Symfony\Component\Process\Process $process
     */
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
        return base_path('vendor/bin/');
    }

    /**
     * Run the underlying command
     *
     * @param array $command
     *
     * @return array<string, bool>
     */
    private function process(array $command): array
    {
        $process = new Process($command);
        $process->run();

        $taskFailedSuccessfully = $this->taskReportsFailure($process);

        if (! $process->isSuccessful() && ! $taskFailedSuccessfully) {
            $taskSuccess = false;
            $output = $process->getErrorOutput();

            $stdOut = $process->getOutput();

            if ($stdOut !== '' && $stdOut !== '0') {
                $output .= "\n";
                $output .= $stdOut;
            }
        } else {
            $taskSuccess = true;
            $output = $process->getOutput();
        }

        $this->newLine();
        $this->line($output);

        return [
            'success' => $taskSuccess,
            'reportsFailure' => $taskFailedSuccessfully,
        ];
    }

    /**
     * @return string[]
     */
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
