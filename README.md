# stickee Canary

Linting and analysing tools for PHP projects.

## Installation

```
mkdir -p tools/canary
composer require --dev --working-dir=tools/canary stickee/canary
tools/canary/vendor/bin/canary install
```

You must commit this new directory and any new config files.

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
vendor/bin/canary analyse
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
vendor/bin/canary fix
```

This command will attempt to fix minor code style issues.

It _can_ be ran against a single file.

It _should_ be ran against staged files as part of the `pre-commit` hook.

PHP-CS-Fixer can be ran using:

```
tools/canary/vendor/bin/php-cs-fixer <COMMAND> --config vendor/stickee/canary/dist/.php-cs-fixer.dist.php
```

See [stickee/php-cs-fixer-config](https://github.com/stickeeuk/php-cs-fixer-config) for more details.
