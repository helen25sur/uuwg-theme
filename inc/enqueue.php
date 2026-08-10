<?php

/**
 * Enqueue theme styles and scripts.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
	exit;
}

function uuwg_enqueue()
{
	wp_register_style('rg_style_fonts', 'https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap');
	wp_enqueue_style('rg_style_fonts');
}

function uuwg_enqueue_assets()
{
	$style_path = UUWG_THEME_DIR . '/style.css';
	wp_enqueue_style(
		'uuwg-style',
		UUWG_THEME_URI . '/style.css',
		array(),
		file_exists($style_path) ? filemtime($style_path) : UUWG_THEME_VERSION
	);

	// Приклад підключення JS для інтерактивних блоків (слайдер, AJAX-фільтри).
	// Розкоментувати, коли з'явиться assets/js/frontend.js
	/*
	$script_path = UUWG_THEME_DIR . '/assets/js/frontend.js';
	wp_enqueue_script(
		'uuwg-frontend',
		UUWG_THEME_URI . '/assets/js/frontend.js',
		array(),
		file_exists( $script_path ) ? filemtime( $script_path ) : UUWG_THEME_VERSION,
		true
	);
	*/
}
add_action('wp_enqueue_scripts', 'uuwg_enqueue_assets');

function uuwg_enqueue_editor_assets()
{
	$style_path = UUWG_THEME_DIR . '/style.css';
	add_editor_style('style.css');
}
add_action('admin_init', 'uuwg_enqueue_editor_assets');

// Дані для JS кастомних блоків (наприклад дефолтні логотипи для превʼю в редакторі)
function uuwg_localize_block_editor_assets()
{
	wp_add_inline_script(
		'wp-blocks', // будь-який core-скрипт, який точно вже підключений в редакторі
		'window.uuwgThemeData = ' . wp_json_encode(array(
			'themeUri' => get_template_directory_uri(),
		)) . ';',
		'before'
	);
}
add_action('enqueue_block_editor_assets', 'uuwg_localize_block_editor_assets');
