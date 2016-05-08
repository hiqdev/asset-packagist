<?php

$header = <<<EOF
Asset Packagist

@link      https://github.com/hiqdev/asset-packagist
@package   asset-packagist
@license   BSD-3-Clause
@copyright Copyright (c) 2016, HiQDev (http://hiqdev.com/)
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

return Symfony\CS\Config\Config::create()
    ->setUsingCache(true)
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers([
        '-long_array_syntax',                    /// Arrays should use the long syntax
        '-php4_constructor',                     /// Convert PHP4-style constructors to __construct. Warning! This could change code behavior
        '-phpdoc_var_to_type',                   /// @var should always be written as @type
        '-align_double_arrow',                   /// Align double arrow symbols in consecutive lines
        '-unalign_double_arrow',                 /// Unalign double arrow symbols in consecutive lines
        '-align_equals',                         /// Align equals symbols in consecutive lines
        '-unalign_equals',                       /// Unalign equals symbols in consecutive lines
        '-blankline_after_open_tag',             /// Ensure there is no code on the same line as the PHP open tag and it is followed by a blankline
        '-phpdoc_no_empty_return',               /// @return void and @return null annotations should be omitted from phpdocs
        '-empty_return',                         /// A return statement wishing to return nothing should be simply "return"
        '-return',                               /// An empty line feed should precede a return statement
        '-phpdoc_params',                        /// All items of the @param, @throws, @return, @var, and @type phpdoc tags must be aligned vertically
        '-phpdoc_scalar',                        /// Scalar types should always be written in the same form. "int", not "integer"; "bool", not "boolean"
        '-phpdoc_separation',                    /// Annotations of a different type are separated by a single blank line
        '-phpdoc_to_comment',                    /// Docblocks should only be used on structural elements
        'header_comment',                        /// Add, replace or remove header comment
        'concat_with_spaces',                    /// Concatenation should be used with at least one whitespace around
        'ereg_to_preg',                          /// Replace deprecated ereg regular expression functions with preg. Warning! This could change code behavior
        'multiline_spaces_before_semicolon',     /// Multi-line whitespace before closing semicolon are prohibited
        'newline_after_open_tag',                /// Ensure there is no code on the same line as the PHP open tag
        'single_blank_line_before_namespace',    /// There should be no blank lines before a namespace declaration
        'ordered_use',                           /// Ordering use statements
        'phpdoc_order',                          /// Annotations in phpdocs should be ordered so that @param come first, then @throws, then @return
        'pre_increment',                         /// Pre incrementation/decrementation should be used if possible
        'short_array_syntax',                    /// PHP arrays should use the PHP 5.4 short-syntax
        'strict',                                /// Comparison should be strict. Warning! This could change code behavior
        'strict_param',                          /// Functions should be used with $strict param. Warning! This could change code behavior
    ])
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()
            ->in(__DIR__)
            ->notPath('vendor')
            ->notPath('runtime')
            ->notPath('web/assets')
            ->notPath('tests/unit/UnitTester.php')
    )
;
