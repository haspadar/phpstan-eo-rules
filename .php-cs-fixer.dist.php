<?php

/*
 * SPDX-FileCopyrightText: 2025 Konstantinas Mesnikas
 * SPDX-License-Identifier: MIT
 */
declare(strict_types=1);

/**
 * PHP CS Fixer configuration for phpstan-eo-rules
 */

$currentYear = (int) date('Y');
$startYear = 2025;
$header = $currentYear === $startYear
    ? "SPDX-FileCopyrightText: $startYear Konstantinas Mesnikas\nSPDX-License-Identifier: MIT"
    : "SPDX-FileCopyrightText: $startYear-$currentYear Konstantinas Mesnikas\nSPDX-License-Identifier: MIT";

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->exclude('vendor')
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        // Header comment
        'header_comment' => [
            'header' => $header,
            'comment_type' => 'comment',
            'location' => 'after_declare_strict',
            'separate' => 'both',
        ],

        // PSR Standards
        '@PER-CS2x0' => true,
        '@PHP8x2Migration' => true,

        // Array formatting
        'array_syntax' => ['syntax' => 'short'],
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays', 'arguments', 'parameters'],
        ],

        // Imports - explicit and organized
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'function', 'const'],
        ],
        'no_unused_imports' => true,
        'no_leading_import_slash' => true,
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => true,
            'import_functions' => true,
        ],

        // Strict types
        'declare_strict_types' => true,

        // Visibility and finality
        'final_class' => true,
        'final_internal_class' => true,

        // Type hints
        'fully_qualified_strict_types' => true,
        'native_type_declaration_casing' => true,

        // Spacing and formatting
        'blank_line_before_statement' => [
            'statements' => ['return', 'throw', 'try'],
        ],
        'class_attributes_separation' => [
            'elements' => [
                'method' => 'one',
                'property' => 'one',
            ],
        ],
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
        ],
        'no_extra_blank_lines' => [
            'tokens' => [
                'extra',
                'throw',
                'use',
            ],
        ],

        // PHPDoc - consistent documentation
        'phpdoc_align' => ['align' => 'left'],
        'phpdoc_indent' => true,
        'phpdoc_no_empty_return' => true,
        'phpdoc_order' => true,
        'phpdoc_scalar' => true,
        'phpdoc_separation' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_trim' => true,
        'phpdoc_types' => true,
        'phpdoc_var_without_name' => true,

        // Clean code
        'no_empty_comment' => true,
        'no_empty_phpdoc' => true,
        'no_empty_statement' => true,
        'no_whitespace_in_blank_line' => true,
        'no_trailing_comma_in_singleline' => true,
        'single_blank_line_at_eof' => true,

        // Risky rules
        'strict_comparison' => true,
        'strict_param' => true,
        'native_constant_invocation' => true,
        'native_function_invocation' => [
            'include' => ['@all'],
        ],

        // Casting
        'cast_spaces' => ['space' => 'single'],
        'lowercase_cast' => true,

        // Control structures
        'control_structure_braces' => true,
        'control_structure_continuation_position' => true,

        // Functions
        'function_declaration' => true,
        'type_declaration_spaces' => true,

        // Operators
        'binary_operator_spaces' => [
            'default' => 'single_space',
        ],
        'concat_space' => ['spacing' => 'one'],
        'unary_operator_spaces' => true,
        'not_operator_with_successor_space' => true,

        // Other
        'encoding' => true,
        'full_opening_tag' => true,
        'single_quote' => true,
        'ternary_operator_spaces' => true,
    ])
    ->setUnsupportedPhpVersionAllowed(true)
    ->setFinder($finder);