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
- an installation command
- shortcuts for running the included tools

## Husky and Lint Staged

[Lint Staged](https://github.com/okonet/lint-staged) can be used to lint staged files and [Husky](https://typicode.github.io/husky) can be used to manage the git pre-commit hook that would call it.

The install command will copy example config files over for these tools but you **must** install them before running it.

## Installation

```
mkdir -p tools/canary
composer require --working-dir=tools/canary stickee/canary
tools/canary/vendor/bin/canary install .
```

You should commit this new directory and any new config files that are generated.

_[Why do we install tools into their own directory?](https://github.com/FriendsOfPHP/PHP-CS-Fixer#installation)_

## Usage

```
tools/canary/vendor/bin/canary
```

### Commands

Canary is simply a wrapper for a bunch of tools.

You can still call them directly.

### `analyse`

[PHPStan](https://github.com/nunomaduro/larastan)

```
tools/canary/vendor/bin/canary analyse
```

This command will perform static-analysis of your whole project.

It _should_ be ran as part of the `pre-commit` hook.

PHPStan can be ran using:
```
tools/canary/vendor/bin/phpstan <COMMAND> -c vendor/stickee/canary/dist/phpstan.dist.neon
```

See [stickee/larastan-config](https://github.com/stickeeuk/larastan-config) for more details.

### `fix`

[PHP CS Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)

```
tools/canary/vendor/bin/canary fix
```

This command will attempt to fix minor code style issues.

It _can_ be ran against a single file.

It _should_ be ran against staged files as part of the `pre-commit` hook.

PHP-CS-Fixer can be ran using:

```
tools/canary/vendor/bin/php-cs-fixer <COMMAND> --config vendor/stickee/canary/dist/.php-cs-fixer.dist.php
```

See [stickee/php-cs-fixer-config](https://github.com/stickeeuk/php-cs-fixer-config) for more details.
