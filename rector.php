<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use RectorLaravel\Set\LaravelSetList;
use RectorLaravel\Set\LaravelLevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/app'
    ]);

    $rectorConfig->sets([
        SetList::DEAD_CODE,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        SetList::TYPE_DECLARATION,
        LevelSetList::UP_TO_PHP_81,
        LaravelSetList::LARAVEL_CODE_QUALITY,
        LaravelLevelSetList::UP_TO_LARAVEL_90,
    ]);

    $rectorConfig->skip([
        // \Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector::class, // Adds return types, which may conflict with Laravel built-ins.
        \Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector::class, // Removes @param from docblocks.
        \Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector::class, // Removes return from docblocks.
        \Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector::class, // Changes $i++ to ++$i.
        \Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector::class, // Changes "th{$is}" to sprintf('th%s', 'is').
        \Rector\Php80\Rector\FunctionLike\MixedTypeRector::class, // Removes docblocks.
    ]);

};
