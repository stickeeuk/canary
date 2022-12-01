<?php

namespace App\Commands;

use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;
use Symfony\Component\Process\Process;

abstract class ToolCommand extends Command
{
    /**
     * The path of the original tool.
     *
     * @var string
     */
    protected string $path;

    /**
     * The command to run.
     *
     * @var string
     */
    protected string $command;

    /**
     * The alias of the command.
     *
     * @var string
     */
    protected ?string $alias = null;

    /**
     * Any options for the command;
     *
     * @var array
     */
    protected array $commandOptions = [];

    public function __construct()
    {
        parent::__construct();
        $this->ignoreValidationErrors(); // allows passing args and options through
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->alias) {
            $this->alias = $this->command;
        }

        $input = $this->input->__toString();
        $name = $input;

        $args = [];

        if ($input !== $this->alias) {
            $input = Str::of($input)->replace($this->alias, '');
            $input = trim($input);

            $args = explode(' ', $input);
            $args = array_map(fn($item): string => trim($item, "'"), $args);
        }

        $command = array_merge(
            [$this->path, $this->command],
            $this->commandOptions,
            $args,
        );

        $success = $this->task($name, function () use ($command) {
            $task = $this->process($command);

            return $task;
        }, 'in progress');

        if (! $success) {
            exit(1); // @phpstan-ignore-line
        }
    }

    private function process(array $command): bool
    {
        $process = new Process($command);
        $process->run();

        if (! $process->isSuccessful()) {
            $success = false;
            $output = $process->getErrorOutput();

            $stdOut = $process->getOutput();

            if ($stdOut) {
                $output .= "\n";
                $output .= $stdOut;
            }
        } else {
            $success = true;
            $output = $process->getOutput();
        }

        $this->line('');
        $this->line($output);

        return $success;
    }
}
