<?php

/**
 * Theme setup: theme supports, menus, patterns category.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
	exit;
}

function uuwg_theme_setup()
{
	add_theme_support('wp-block-styles');
	add_theme_support('editor-styles');
	add_theme_support('responsive-embeds');
	add_theme_support('post-thumbnails');
	add_theme_support('align-wide');

	// Мовна підтримка (Polylang перекладає рядки через __() / _e(), text domain нижче).
	load_theme_textdomain('uuwg', UUWG_THEME_DIR . '/languages');

	register_nav_menus(
		array(
			'primary' => __('Головне меню', 'uuwg'),
			'footer'  => __('Меню футера', 'uuwg'),
		)
	);
}
add_action('after_setup_theme', 'uuwg_theme_setup');

/**
 * Категорія для власних block patterns (наприклад "UUWG Sections").
 */
function uuwg_register_pattern_category()
{
	register_block_pattern_category(
		'uuwg-sections',
		array('label' => __('UUWG Sections', 'uuwg'))
	);
}
add_action('init', 'uuwg_register_pattern_category');

/**
 * Allow SVG uploads.
 */
function uuwg_allow_svg_uploads($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

add_filter('upload_mimes', 'uuwg_allow_svg_uploads');

/**
 * Fix SVG MIME type.
 */
function uuwg_fix_svg_mime_type($data, $file, $filename, $mimes)
{

	$filetype = wp_check_filetype($filename, $mimes);

	if ('svg' === $filetype['ext']) {
		$data['type'] = 'image/svg+xml';
		$data['ext']  = 'svg';
	}

	return $data;
}

add_filter('wp_check_filetype_and_ext', 'uuwg_fix_svg_mime_type', 10, 4);