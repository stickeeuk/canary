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
- shortcuts to run the included tools
- an installation command

## Husky and Lint Staged

[Lint Staged](https://github.com/okonet/lint-staged) can be used to lint staged files and [Husky](https://typicode.github.io/husky) can be used to manage the pre-commit hook that would call it.

The `install` command will copy example configs over for these tools but you **must** install them before running it.

## Installation

```bash
mkdir -p tools/canary
composer require --working-dir=tools/canary stickee/canary
tools/canary/vendor/bin/canary install
```

_[Why do we install tools into their own directory?](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer#installation)_

You should commit this new directory and the config files that are installed.

## Usage

Canary provides a unified and decoupled platform for making use of powerful linting and static analysis tools that we make heavy use of at stickee.

### Options

To pass options through you must write them after a `--`.

```bash
tools/canary/vendor/bin/canary analyse -- -c phpstan.ci.neon --error-format=github
```

### Commands

### `analyse`

[PHPStan](https://github.com/nunomaduro/larastan)

```bash
tools/canary/vendor/bin/canary analyse -- -c phpstan.dist.neon
```

This command will perform static-analysis of your whole project.

It _should_ be ran as part of the `pre-commit` hook.

See [stickee/larastan-config](https://github.com/stickeeuk/larastan-config) for more details.

### `fix`

[PHP CS Fixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer)

```bash
tools/canary/vendor/bin/canary fix -- --config .php-cs-fixer.dist.php
```

This command will attempt to fix minor code style issues.

It _can_ be ran against a single file.

It _should_ be ran against staged files as part of the `pre-commit` hook.

See [stickee/php-cs-fixer-config](https://github.com/stickeeuk/php-cs-fixer-config) for more details.

### `suggest`

[Rector](https://github.com/rectorphp/rector) in `--dry-run` mode

```bash
tools/canary/vendor/bin/canary suggest
```

This command will suggest improvements as diffs in the terminal.

Any `suggest`ed improvements must be performed manually or you can run the `improve` command to do it for you.

See [stickee/rector-config](https://github.com/stickeeuk/rector-config) for more details.

### `improve`

[Rector](https://github.com/rectorphp/rector)

```bash
tools/canary/vendor/bin/canary improve
```

This command will refactor your code in an attempt to improve it.

Any `improve`d code **must** be checked before committing.

It _can_ be ran against a single file.

It should **not** be ran as part of the `pre-commit` hook.

See [stickee/rector-config](https://github.com/stickeeuk/rector-config) for more details.

#### Note

You _may_ find it useful to add these `improve`ments as patches with Git.

You could use a Git integration in your editor or stage the `improve`ments as patches with:

```bash
git add <file> -p
```

## Contributions

Contributions are welcome! Canary is written using [Laravel Zero](https://github.com/laravel-zero/laravel-zero).
Improvements to any of the amalgamated open source tools should be directed towards their respective repositories.

You are encouraged to provide tests, which are written using the [Pest](https://github.com/pestphp/pest) testing framework.

## License

Canary is open source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
