<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;
use function Termwind\{render};

class InstallCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'install
                            {directory=cwd() : The directory to copy files into}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Installs Canary config files';

    private string $destination = '';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        if ($this->argument('directory') !== 'cwd()') {
            $this->destination = $this->argument('directory');
        }

        render(<<<'HTML'
            <div class="py-1">
                <div class="px-1 bg-yellow-300 text-black">Install</div>
            </div>
        HTML);

        if ($this->tasks()) {
            render(<<<'HTML'
                <div class="py-1">
                    <div class="text-yellow-300">Done.</div>
                    <div class="text-yellow-300">You should review any new files and commit them to git.</div>
                </div>
            HTML);
        }
    }

    private function tasks(): bool
    {
        if ($this->destination) {
            $success = true;
            $disk = Storage::disk('cwd');
            if (!$disk->exists($this->destination)) {
                $success = false;
            }

            $this->task('Destination directory exists', fn() => $success);

            if (!$success) {
                render(<<<'HTML'
                <div class="py-1">
                    <div class="bg-red-500">The destination directory must exist to copy files to.</div>
                </div>
            HTML);
                return $success;
            }
        }

        $this->task('Copy PHP CS Fixer config', function () {
            $this->copyFilesFromVendorDirectory('stickee/php-cs-fixer-config/dist');
        });

        $this->task('Copy Larastan config', function () {
            $this->copyFilesFromVendorDirectory('stickee/larastan-config/dist');
        });

        $this->task('Copy Husky pre-commit', function() {
            $file = '.husky/pre-commit';
            $this->copyFileToCwd('local', $file, $file);
        });

        $this->task('Copy Lint Staged config', function() {
            $this->copyFileToCwd('local', '.lintstagedrc.json');
        });

        $gitignore = '.gitignore';
        $amendedGitIgnore = $this->task('.gitignore includes .php-cs-fixer.cache', function () use ($gitignore) {
            $disk = Storage::disk('cwd');
            $path = $this->destination ? $this->destination . DIRECTORY_SEPARATOR . $gitignore : $gitignore;

            if (!$disk->exists($path)) {
                return false;
            }

            $original = $disk->get($path);
            $needle = '.php-cs-fixer.cache';

            if (Str::of($original)->contains($needle)) {
                return true;
            }

            $disk->append($path, $needle);
        });

        if (!$amendedGitIgnore) {
            $this->line('');
            $this->error("Could not find your {$gitignore} file.");
            $this->error("Please create a {$gitignore} file or ensure you are installing into the correct directory.");
        }

        return $amendedGitIgnore;
    }

    private function copyFilesFromVendorDirectory(string $directory): void
    {
        $this->copyFilesFromDiskDirectory($directory, 'vendor');
    }

    private function copyFilesFromDiskDirectory(string $directory, string $disk): void
    {
        $files = Storage::disk($disk)->allFiles($directory);

        foreach ($files as $file) {
            $this->copyFileToCwd($disk, $file, $this->getFileName($file, $directory));
        }
    }

    private function copyFileToCwd(string $disk, string $src, ?string $dest = null): void
    {
        if (is_null($dest)) {
            $dest = $src;
        }

        if ($this->destination) {
            $dest = $this->destination . DIRECTORY_SEPARATOR . $dest;
        }

        Storage::disk('cwd')->put($dest, Storage::disk($disk)->get($src));
    }

    private function getFileName(string $path, string $directory): string
    {
        return Str::replace($directory . DIRECTORY_SEPARATOR, '', $path);
    }
}
