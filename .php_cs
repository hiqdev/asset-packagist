<?php

$header = <<<EOF
Asset Packagist

@link      https://github.com/hiqdev/asset-packagist
@package   asset-packagist
@license   BSD-3-Clause
@copyright Copyright (c) 2016-2017, HiQDev (http://hiqdev.com/)
EOF;

return PhpCsFixer\Config::create()
    ->setUsingCache(true)
    ->setRiskyAllowed(true)
    ->setRules(array(
        '@Symfony' => true,
        'header_comment'                             =>  [
            'header'        => $header,
            'separate'      => 'bottom',
            'location'      => 'after_declare_strict',
            'commentType'   => 'PHPDoc',
        ],
        'binary_operator_spaces'                     =>  [
            'align_double_arrow' => null,
            'align_equals'       => null,
        ],
        'concat_space'                               =>  ['spacing' => 'one'],
        'array_syntax'                               =>  ['syntax' => 'short'],
        'blank_line_before_return'                   =>  false,
        'phpdoc_align'                               =>  false,
        'phpdoc_scalar'                              =>  false,
        'phpdoc_separation'                          =>  false,
        'phpdoc_to_comment'                          =>  false,
        'method_argument_space'                      =>  false,
        'ereg_to_preg'                               =>  true,
        'blank_line_after_opening_tag'               =>  true,
        'single_blank_line_before_namespace'         =>  true,
        'ordered_imports'                            =>  true,
        'phpdoc_order'                               =>  true,
        'pre_increment'                              =>  true,
        'strict_comparison'                          =>  true,
        'strict_param'                               =>  true,
        'no_multiline_whitespace_before_semicolons'  =>  true,
    ))
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__)
            ->notPath('vendor')
            ->notPath('runtime')
            ->notPath('web/assets')
        )
;
