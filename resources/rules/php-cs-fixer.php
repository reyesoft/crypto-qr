<?php
$project_name = 'CryptoQr';
$config = require __DIR__.'/../../vendor/reyesoft/ci/php/rules/php-cs-fixer.dist.php';

// rules override
$rules = array_merge(
    $config->getRules(),
    [
        'strict_comparison' => false,
        'no_useless_else' => false,
    ]
);

return $config
    ->setRules($rules)
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in('./src')
            ->in('./tests')
    );
