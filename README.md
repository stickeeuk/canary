<p align="center" style="padding:1rem">
    <picture>
      <source media="(prefers-color-scheme: dark)" srcset=".github/images/logo-yellow.png" width="500">
      <source media="(prefers-color-scheme: light)" srcset=".github/images/logo-dark.png" width="500">
      <img alt="Stickee Canary" src=".github/images/logo-dark.png" width="500">
    </picture>
</p>

<p align="center">
    <img src="https://img.shields.io/github/contributors/stickeeuk/canary" alt="Contributors">
    <a href="https://packagist.org/packages/stickee/canary"><img src="https://img.shields.io/packagist/dt/stickee/canary" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/stickee/canary"><img src="https://img.shields.io/packagist/l/stickee/canary" alt="License"></a>
    <a href="https://packagist.org/packages/stickee/canary"><img src="https://img.shields.io/packagist/v/stickee/canary" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/stickee/canary"><img src="https://img.shields.io/packagist/dependency-v/stickee/canary/php" alt="PHP Version"></a>
</p>

# Introduction

**Canary** provides **linting** and **static analysis** for Laravel applications and Composer packages.

It includes:

- PHP CS Fixer with Stickee's rulesets and custom fixer. [PHP CS Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)
- PHPStan with Larastan available for Laravel projects. [PHPStan](https://phpstan.org/) · [Larastan](https://github.com/larastan/larastan)
- Rector with Laravel rules available for Laravel projects. [Rector](https://github.com/rectorphp/rector)

## Installation

### Composer

```bash
composer require --dev stickee/canary

# Add scripts to composer.json
composer config scripts.analyse 'phpstan analyse -c phpstan.dist.neon'
composer config scripts.analyze '@analyse'
composer config scripts.fix 'php-cs-fixer fix --config .php-cs-fixer.php'
composer config scripts.improve 'rector process'
composer config scripts.suggest 'rector process --dry-run'
```

### Config

Choose the config for your project and save the files in the project root.

#### Laravel applications

```bash
cp vendor/stickee/canary/dist/laravel-app/.php-cs-fixer.php .
cp vendor/stickee/canary/dist/laravel-app/phpstan.dist.neon .
cp vendor/stickee/canary/dist/laravel-app/rector.php .
```

#### Generic Composer packages

```bash
cp vendor/stickee/canary/dist/package/.php-cs-fixer.php .
cp vendor/stickee/canary/dist/package/phpstan.dist.neon .
cp vendor/stickee/canary/dist/package/rector.php .
```

This config uses plain PHPStan and core Rector rules. If your project uses `phpstan/extension-installer`, add `larastan/larastan` to `extra.phpstan/extension-installer.ignore` in `composer.json` to keep Larastan disabled. For extensions already included in your PHPStan config, use either automatic registration or an explicit include. [PHPStan extension installer](https://github.com/phpstan/extension-installer#ignoring-a-particular-extension)

#### Laravel packages

```bash
cp vendor/stickee/canary/dist/package/.php-cs-fixer.php .
cp vendor/stickee/canary/dist/laravel-package/phpstan.dist.neon .
cp vendor/stickee/canary/dist/laravel-package/rector.php .
```

This config enables Larastan and Laravel Rector rules. If the package needs a Laravel application container for analysis, install a compatible version of `orchestra/testbench` as a development dependency. If Larastan needs bindings from your package's service providers, list the providers under `providers` in `testbench.yaml`. [Larastan package setup](https://github.com/larastan/larastan#-getting-started-in-3-steps) · [Testbench version compatibility](https://packages.tools/testbench#version-compatibility)

Both package configs target `src/`. PHP CS Fixer also covers `tests/` when it exists. Adjust the paths in the three config files if your package uses a different layout.

#### CI and cache

For GitHub Actions, any project type can copy the CI config and use it with `composer analyse -- --configuration=phpstan.ci.neon`.

```bash
cp vendor/stickee/canary/dist/phpstan.ci.neon .
```

Example workflows are available for [Laravel app analysis](dist/ci/phpstan.yaml) and [style fixes](dist/ci/php-cs-fixer.yaml).

Commit your config files and add `.php-cs-fixer.cache` to `.gitignore`.

```bash
if grep -q '.php-cs-fixer.cache' .gitignore;
then
    echo ".gitignore contains .php-cs-fixer.cache";
else
    echo "Adding .php-cs-fixer.cache to .gitignore";
    echo ".php-cs-fixer.cache" >> .gitignore;
    echo "Done";
fi
```

## Usage

### `analyse`

```bash
composer analyse
```

PHPStan analyses the paths in `phpstan.dist.neon`. `composer analyze` is an alias for the same command.

It _could_ be run as part of a `pre-commit` hook.

### `fix`

[PHP CS Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)

```bash
composer fix
```

This command will attempt to fix minor code style issues.

It _can_ be run against a single file.

It _could_ be run against staged files as part of a `pre-commit` hook.

### `improve`

[Rector](https://github.com/rectorphp/rector)

```bash
composer improve
```

This command will refactor your code in an attempt to improve it.

Any `improve`d code **must** be checked before committing.

It _can_ be run against a single file.

It should **not** be run as part of a `pre-commit` hook.

### `suggest`

[Rector](https://github.com/rectorphp/rector) in `--dry-run` mode

```bash
composer suggest
```

This command will suggest improvements as diffs in the terminal.

## Contributions

Contributions are welcome!

Open issues for the tools themselves in their respective repositories.

Canary's configuration and fixer code come from Stickee's companion packages. [Larastan config v3.1.1](https://github.com/stickeeuk/larastan-config/tree/v3.1.1) · [PHP CS Fixer config v3.0.2](https://github.com/stickeeuk/php-cs-fixer-config/tree/v3.0.2) · [Rector config v4.0.1](https://github.com/stickeeuk/rector-config/tree/v4.0.1)

## License

Canary is open source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
