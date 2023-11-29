<?php

declare(strict_types=1);

namespace App\Commands;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use LaravelZero\Framework\Commands\Command;

use function Termwind\{render};

class InstallCommand extends Command
{
    /**
     * @var string
     */
    private const DEFAULT_INSTALL_DIRECTORY = 'cwd()';

    /** @var string */
    protected $signature = 'install
                            {directory=' . self::DEFAULT_INSTALL_DIRECTORY . ' : The directory to copy files into}';

    /** @var string */
    protected $description = 'Installs Canary config files';

    private string $destination = '';

    public function handle(): int
    {
        if ($this->argument('directory') !== self::DEFAULT_INSTALL_DIRECTORY) {
            $this->destination = rtrim($this->argument('directory'), '/') . DIRECTORY_SEPARATOR;
        }

        render(<<<'HTML'
                <div class="py-1">
                    <div class="px-1 bg-yellow-300 text-black">Install</div>
                </div>
            HTML);

        if (! $this->tasks()) {
            return 1;
        }

        render(<<<'HTML'
                <div class="py-1">
                    <div class="text-yellow-300">Done.</div>
                    <div class="text-yellow-300">You should review any new files and commit them to Git.</div>
                </div>
            HTML);

        return 0;
    }

    private function tasks(): bool
    {
        if (! $this->ensureDestinationDirectoryExists()) {
            return false;
        }

        $this->task('Copy PHP CS Fixer config', function (): void {
            $this->copyFilesFromVendorDirectory('stickee/php-cs-fixer-config/dist');
        });

        $this->task('Copy Larastan config', function (): bool {
            $this->copyFilesFromVendorDirectory('stickee/larastan-config/dist');

            return $this->amendLarastanConfig();
        });

        $this->task('Copy Rector config', function (): void {
            $this->copyFilesFromVendorDirectory('stickee/rector-config/dist');
        });

        $this->task('Copy Husky pre-commit', function (): void {
            $file = '.husky' . DIRECTORY_SEPARATOR . 'pre-commit';
            $this->copyFileToCwd('local', $file, $file);
        });

        $this->task('Copy Lint Staged config', function (): void {
            $this->copyFileToCwd('local', '.lintstagedrc.json');
        });

        $this->task('Copy example GitHub Workflow', function (): void {
            $file = '.github' . DIRECTORY_SEPARATOR . 'workflows' . DIRECTORY_SEPARATOR . 'php.yaml';
            $this->copyFileToCwd('local', $file);
        });

        return $this->amendGitignore();
    }

    private function ensureDestinationDirectoryExists(): bool
    {
        $success = true;
        $disk = Storage::disk('cwd');

        if (! $disk->exists($this->destination)) {
            $success = false;
        }

        $this->task('Destination directory exists', static fn(): bool => $success);

        if (! $success) {
            render(<<<'HTML'
                    <div class="py-1">
                        <div class="bg-red-500">The destination directory must exist to copy files to.</div>
                    </div>
                HTML);
        }

        return $success;
    }

    private function amendLarastanConfig(): bool
    {
        $larastanConfig = 'phpstan.dist.neon';

        $disk = Storage::disk('cwd');
        $path = $this->destination . $larastanConfig;

        if (! $disk->exists($path)) {
            $this->newLine();
            $this->error('Something went wrong.');
            $this->error("Could not amend your {$larastanConfig} file.");

            return false;
        }

        $original = $disk->get($path);

        $new = Str::of($original)->replaceMatches(
            pattern: '/tools\/phpstan\//m',
            replace: 'tools/canary/'
        );

        $disk->put($path, (string) $new);

        return true;
    }

    private function amendGitignore(): bool
    {
        $gitignore = '.gitignore';
        $amendedGitIgnore = $this->task('.gitignore includes .php-cs-fixer.cache', function () use ($gitignore) {
            $disk = Storage::disk('cwd');
            $path = $this->destination . $gitignore;

            if (! $disk->exists($path)) {
                return false;
            }

            $original = $disk->get($path);
            $needle = '.php-cs-fixer.cache';

            if (Str::of($original)->contains($needle)) {
                return true;
            }

            $disk->append($path, $needle);
        });

        if (! $amendedGitIgnore) {
            $this->newLine();
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
        if ($dest === null) {
            $dest = $src;
        }

        if ($this->destination !== '') {
            $dest = $this->destination . $dest;
        }

        Storage::disk('cwd')->put($dest, Storage::disk($disk)->get($src));
    }

    private function getFileName(string $path, string $directory): string
    {
        return Str::replace($directory . DIRECTORY_SEPARATOR, '', $path);
    }
}
