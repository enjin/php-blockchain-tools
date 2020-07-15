<?php

$finder = PhpCsFixer\Finder::create()
	->notPath('bootstrap/cache')
	->notPath('storage')
	->notPath('vendor')
	->notPath('setup')
	->in(__DIR__)
	->name('*.php')
	->notName('*.blade.php')
	->ignoreDotFiles(true)
	->ignoreVCS(true);

$config = PhpCsFixer\Config::create()
	->setFinder($finder)
	->setRiskyAllowed(true)
	->setLineEnding("\n")
	->setRules([
		'@PSR1' => true,
		'@PSR2' => true,
		'align_multiline_comment' => true,
		'array_indentation' => true,
		'backtick_to_shell_exec' => true,
		'blank_line_after_opening_tag' => true,
		'blank_line_before_statement' => true,
		'cast_spaces' => true,
		'combine_consecutive_issets' => true,
		'combine_consecutive_unsets' => true,
		'combine_nested_dirname' => true,
		'comment_to_phpdoc' => true,
		'compact_nullable_typehint' => true,
		'declare_equal_normalize' => true,
		'dir_constant' => true,
		'single_line_comment_style' => true,
		'explicit_indirect_variable' => true,
		'explicit_string_variable' => true,
		'fully_qualified_strict_types' => true,
		'function_to_constant' => true,
		'function_typehint_space' => true,
		'hash_to_slash_comment' => true,
		'heredoc_to_nowdoc' => true,
		'implode_call' => true,
		'include' => true,
		'linebreak_after_opening_tag' => true,
		'list_syntax' => true,
		'logical_operators' => true,
		'lowercase_cast' => true,
		'lowercase_constants' => true,
		'lowercase_static_reference' => true,
		'magic_constant_casing' => true,
		'magic_method_casing' => true,
		'method_chaining_indentation' => true,
		'modernize_types_casting' => true,
		'multiline_comment_opening_closing' => true,
		'multiline_whitespace_before_semicolons' => true,
		'native_function_casing' => true,
		'no_alias_functions' => true,
		'no_alternative_syntax' => true,
		'no_binary_string' => true,
		'no_blank_lines_after_phpdoc' => true,
		'no_empty_phpdoc' => true,
		'no_empty_statement' => true,
		'no_extra_consecutive_blank_lines' => true,
		'no_leading_import_slash' => true,
		'no_leading_namespace_whitespace' => true,
		'no_mixed_echo_print' => true,
		'no_multiline_whitespace_around_double_arrow' => true,
		'no_multiline_whitespace_before_semicolons' => true,
		'no_null_property_initialization' => true,
		'no_php4_constructor' => true,
		'no_short_bool_cast' => true,
		'no_short_echo_tag' => true,
		'no_singleline_whitespace_before_semicolons' => true,
		'no_spaces_around_offset' => true,
		'no_trailing_comma_in_list_call' => true,
		'no_trailing_comma_in_singleline_array' => true,
		'no_unneeded_control_parentheses' => true,
		'no_unneeded_curly_braces' => true,
		'no_unneeded_final_method' => true,
		'no_unreachable_default_argument_value' => true,
		'no_unused_imports' => true,
		'no_useless_else' => true,
		'no_useless_return' => true,
		'no_whitespace_before_comma_in_array' => true,
		'no_whitespace_in_blank_line' => true,
		'non_printable_character' => true,
		'normalize_index_brace' => true,
		'object_operator_without_whitespace' => true,
		'ordered_class_elements' => true,
		'ordered_imports' => true,
		'ordered_interfaces' => true,
		'php_unit_construct' => true,
		'php_unit_dedicate_assert' => true,
		'php_unit_dedicate_assert_internal_type' => true,
		'php_unit_expectation' => true,
		'php_unit_method_casing' => true,
		'phpdoc_indent' => true,
		'phpdoc_no_access' => true,
		'phpdoc_no_alias_tag' => true,
		'phpdoc_no_empty_return' => true,
		'phpdoc_no_package' => true,
		'phpdoc_order' => true,
		'phpdoc_scalar' => true,
		'phpdoc_separation' => true,
		'phpdoc_trim' => true,
		'phpdoc_types' => true,
		'phpdoc_var_without_name' => true,
		'phpdoc_summary' => true,
		'phpdoc_trim_consecutive_blank_line_separation' => true,
		'pow_to_exponentiation' => true,
		'psr4' => true,
		'random_api_migration' => true,
		'self_accessor' => true,
		'semicolon_after_instruction' => true,
		'short_scalar_cast' => true,
		'simple_to_complex_string_variable' => true,
		'simplified_null_return' => true,
		'single_blank_line_before_namespace' => true,
		'single_quote' => true,
		'space_after_semicolon' => true,
		'standardize_increment' => true,
		'standardize_not_equals' => true,
		'string_line_ending' => true,
		'ternary_operator_spaces' => true,
		'ternary_to_null_coalescing' => true,
		'trailing_comma_in_multiline_array' => true,
		'trim_array_spaces' => true,
		'unary_operator_spaces' => true,
		'whitespace_after_comma_in_array' => true,
		'no_closing_tag' => true,
		'no_spaces_inside_parenthesis' => true,
		'no_spaces_after_function_name' => true,
		'single_line_after_imports' => true,
		'single_import_per_statement' => true,
		'switch_case_semicolon_to_colon' => true,
		'switch_case_space' => true,
		'binary_operator_spaces' => [
			'default' => 'single_space',
			'operators' => [
				'=>' => null
			]
		],
		'array_syntax' => [
			'syntax' => 'short'
		],
		'class_attributes_separation' => [
			'elements' => [
				'method'
			]
		],
		'concat_space' => [
			'spacing' => 'one'
		],
		'general_phpdoc_annotation_remove' => [
			'annotations' => [
				'author'
			]
		],
		'increment_style' => [
			'style' => 'post'
		],
		'is_null' => [
			'use_yoda_style' => false
		],
		'no_extra_blank_lines' => [
			'tokens' => [
				'break',
				'continue',
				'throw',
				'use'
			]
		],
    ]);

return $config;
