# Upgrade guide

## Upgrading to `4.0` from `3.x`

This is a major release with lots of breaking changes coming from the tools Canary relies on, mainly PHPStan going from `v1` to `v2`.

Please first read [Larastan's upgrade guide](https://github.com/larastan/larastan/blob/3.x/UPGRADE.md) and then come back here before you do anything.

### Code related to Carbon has been removed
######  Likelihood Of Impact: None

This part of the Larastan guide has been done for you.

### Other dependencies that rely on PHPStan
######  Likelihood Of Impact: Low

You _may_ need to update other dependencies that rely on PHPStan, such as `spatie/laravel-ray`.

```sh
composer update namespace/name --with-all-dependencies
```

### Canary installation directory has changed
######  Likelihood Of Impact: High but not technically necessary

PHP CS Fixer changed their recommendation on where to install tools and we have followed that recommendation with Canary.

Instead of installing into the `tools/canary` directory, Canary should now be installed into the same directory as your app.

```sh
rm -rf tools/canary
composer require --dev stickee/canary:^4
```

### Correct return types for model relation methods
######  Likelihood Of Impact: High

Larastan has made a change which means that models should now return generic types for their relations.

**After** updating to Canary v4 you can run Rector to add these for you.

```sh
vendor/bin/rector process app -c vendor/stickee/rector-config/dist/add-generic-return-type-to-relations.php
```

If you have any issues with this you can try:

```sh
# removing the memory limit
vendor/bin/rector process app -c vendor/stickee/rector-config/dist/add-generic-return-type-to-relations.php --memory-limit=-1
```
and/or 

```sh
# limit Rector to only the models directory
vendor/bin/rector process app/Models -c vendor/stickee/rector-config/dist/add-generic-return-type-to-relations.php
```

or alternatively follow the [Larastan guide](https://github.com/larastan/larastan/blob/3.x/UPGRADE.md#correct-return-types-for-model-relation-methods) directly.

### Configuration files
######  Likelihood Of Impact: High

Some of the configuration files have been updated.

You should follow the Installation Instructions from the README to copy the config files into your repo and commit them.

### GitHub Actions Workflow
######  Likelihood Of Impact: High

You will need to change the commands that GitHub Actions runs in a `.github/workflows/php.yaml` or equivalent file.

```diff
- tools/canary/vendor/bin/canary analyse
+ vendor/bin/phpstan analyse
```

```diff
- tools/canary/vendor/bin/canary fix
+ vendor/bin/php-cs-fixer fix
```
