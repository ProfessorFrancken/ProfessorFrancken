<?php

$config = new PhpCsFixer\Config();

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__ . '/src/')
    ->in(__DIR__ . '/tests/')
    ->in(__DIR__ . '/routes/')
        ;

$config->setRules([
    "psr_autoloading" => true,
    '@PSR1' => true,
    '@PSR2' => true,
    'array_syntax' => ['syntax' => 'short'],
    'blank_line_after_opening_tag' => true,
    'braces' => true,
    'compact_nullable_typehint' => true,
    'concat_space' => ['spacing' => 'one'],
    'date_time_immutable' => true,
    'declare_strict_types' => true,
    'elseif' => true,
    'encoding' => true,
    'full_opening_tag' => true,
    'fully_qualified_strict_types' => true,
    'function_declaration' => true,
    'function_typehint_space' => true,
    'lowercase_cast' => true,
    'constant_case' => true,
    'lowercase_keywords' => true,
    'lowercase_static_reference' => true,
    'magic_constant_casing' => true,
    'magic_method_casing' => true,
    'method_argument_space' => true,
    'native_function_casing' => true,
    'new_with_braces' => true,
    'no_blank_lines_after_class_opening' => true,
    'no_empty_phpdoc' => true,
    'no_empty_statement' => true,
    'no_superfluous_elseif' => true,
    'no_superfluous_phpdoc_tags' => true,
    'no_unreachable_default_argument_value' => true,
    'no_unused_imports' => true,
    'no_useless_else' => true,
    'no_useless_return' => true,
    'not_operator_with_space' => true,
    'ordered_class_elements' => true,
    'ordered_imports' => true,
    'php_unit_construct' => true,
    'php_unit_expectation' => true,
    'php_unit_fqcn_annotation' => true,
    'php_unit_method_casing' => ['case' => 'snake_case'],
    'php_unit_namespaced' => true,
    'phpdoc_add_missing_param_annotation' => ['only_untyped' => true],
    'phpdoc_indent' => true,
    'phpdoc_no_access' => true,
    'phpdoc_no_package' => true,
    'phpdoc_scalar' => true,
    'phpdoc_trim' => true,
    'phpdoc_types' => true,
    'phpdoc_var_without_name' => true,
    'protected_to_private' => true,
    'return_type_declaration' => ['space_before' => 'one'],
    'self_accessor' => true,
    'short_scalar_cast' => true,
    'single_blank_line_at_eof' => true,
    'single_blank_line_before_namespace' => true,
    'space_after_semicolon' => true,
    'strict_param' => true,
    'switch_case_semicolon_to_colon' => true,
    'switch_case_space' => true,
    'trim_array_spaces' => true,
    'unary_operator_spaces' => true,
    'visibility_required' => true,
    'void_return' => true,
    'whitespace_after_comma_in_array' => true,
    'yoda_style' => false,
])
    ->setFinder($finder)
    ->setRiskyAllowed(true);

return $config;
