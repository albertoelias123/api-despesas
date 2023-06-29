<?php

$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR12' => true
        ])
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude('database/migrations')
            ->exclude('storage')
            ->notPath('_ide_helper.php')
            ->in(__DIR__)
    );
;
