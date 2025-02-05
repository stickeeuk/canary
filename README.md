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

**Canary** provides **linting** and **static analysis** for stickee Laravel projects.

It includes:

- the stickee [PHP CS Fixer config](https://github.com/stickeeuk/php-cs-fixer-config/) to adhere to our code styles
- the stickee [Larastan config](https://github.com/stickeeuk/larastan-config/) to analyse your code
- the stickee [Rector config](https://github.com/stickeeuk/rector-config) to refactor your code

## Installation

### Composer

```bash
composer require --dev stickee/canary
```

### Config

```bash
cp vendor/stickee/php-cs-fixer-config/dist/.php-cs-fixer.php .
cp vendor/stickee/larastan-config/dist/phpstan.dist.neon .
cp vendor/stickee/larastan-config/dist/phpstan.ci.neon .
cp vendor/stickee/rector-config/dist/rector.php .
```

You should commit these config files.

### .gitignore

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

Canary provides a unified package that brings together powerful linting and static analysis tools that we make heavy use of at stickee.

### Tools

### `analyse`

[PHPStan](https://github.com/nunomaduro/larastan)

```bash
vendor/bin/phpstan analyse -c phpstan.dist.neon
```

This command will perform static-analysis of your whole project.

It _could_ be ran as part of a `pre-commit` hook.

See [stickee/larastan-config](https://github.com/stickeeuk/larastan-config) for more details.

### `fix`

[PHP CS Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)

```bash
vendor/bin/php-cs-fixer fix --config .php-cs-fixer.php
```

This command will attempt to fix minor code style issues.

It _can_ be ran against a single file.

It _could_ be ran against staged files as part of a `pre-commit` hook.

See [stickee/php-cs-fixer-config](https://github.com/stickeeuk/php-cs-fixer-config) for more details.

### `improve`

[Rector](https://github.com/rectorphp/rector)

```bash
vendor/bin/rector
```

This command will refactor your code in an attempt to improve it.

Any `improve`d code **must** be checked before committing.

It _can_ be ran against a single file.

It should **not** be ran as part of a `pre-commit` hook.

See [stickee/rector-config](https://github.com/stickeeuk/rector-config) for more details.

### `suggest`

[Rector](https://github.com/rectorphp/rector) in `--dry-run` mode

```bash
vendor/bin/rector --dry-run
```

This command will suggest improvements as diffs in the terminal.

See [stickee/rector-config](https://github.com/stickeeuk/rector-config) for more details.

## Contributions

Contributions are welcome!

Improvements to any of the amalgamated open source tools should be directed towards their respective repositories.

## License

Canary is open source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
