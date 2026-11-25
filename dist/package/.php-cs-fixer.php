<?php

declare(strict_types=1);

use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;
use Stickee\PhpCsFixerConfig\Factory;
use Stickee\PhpCsFixerConfig\RuleSet\Php83;

$finder = Finder::create()
    ->in(__DIR__ . '/src')
    ->append([__FILE__]);

if (is_dir(__DIR__ . '/tests')) {
    $finder->in(__DIR__ . '/tests');
}

return Factory::fromRuleSet(new Php83(), [
    'ordered_class_elements' => ['order' => ['use_trait']],
])
    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache')
    ->setParallelConfig(ParallelConfigFactory::detect());
