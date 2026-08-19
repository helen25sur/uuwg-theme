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

	$style_main_path = UUWG_THEME_DIR . '/assets/css/main.css';
	wp_enqueue_style(
		'uuwg-main-style',
		UUWG_THEME_URI . '/assets/css/main.css',
		array(),
		file_exists($style_main_path) ? filemtime($style_main_path) : UUWG_THEME_VERSION
	);

	// Приклад підключення JS для інтерактивних блоків (слайдер, AJAX-фільтри).
	// Розкоментувати, коли з'явиться assets/js/frontend.js

	$script_path = UUWG_THEME_DIR . '/assets/js/message-popup.js';
	wp_enqueue_script(
		'uuwg-message-popup',
		UUWG_THEME_URI . '/assets/js/message-popup.js',
		array(),
		file_exists($script_path) ? filemtime($script_path) : UUWG_THEME_VERSION,
		true
	);

	$script_nav_path = UUWG_THEME_DIR . '/assets/js/navigation.js';
	wp_enqueue_script(
		'uuwg-navigation',
		UUWG_THEME_URI . '/assets/js/navigation.js',
		array(),
		file_exists($script_nav_path) ? filemtime($script_nav_path) : UUWG_THEME_VERSION,
		true
	);

	$script_scroll_path = UUWG_THEME_DIR . '/assets/js/scroll.js';
	wp_enqueue_script(
		'uuwg-scroll-js',
		UUWG_THEME_URI . '/assets/js/scroll.js',
		array(),
		file_exists($script_scroll_path) ? filemtime($script_scroll_path) : UUWG_THEME_VERSION,
		true
	);

	$script_pagination_path = UUWG_THEME_DIR . '/assets/js/pagination.js';
	wp_enqueue_script(
		'uuwg-pagination-js',
		UUWG_THEME_URI . '/assets/js/pagination.js',
		array(),
		file_exists($script_pagination_path) ? filemtime($script_pagination_path) : UUWG_THEME_VERSION,
		true
	);
}
add_action('wp_enqueue_scripts', 'uuwg_enqueue_assets');

function uuwg_enqueue_editor_assets()
{
	$style_path = UUWG_THEME_DIR . '/assets/css/style.css';
	add_editor_style('style.css');
}
add_action('admin_init', 'uuwg_enqueue_editor_assets');

function uuwg_add_editor_styles()
{
	// 1. Вмикаємо підтримку кастомних стилів редактора
	add_theme_support('editor-styles');

	// 2. Вказуємо шлях відносно КОРЕНЯ теми (без get_template_directory_uri())
	// Наприклад, якщо файл у: wp-content/themes/uuwg-theme/assets/css/editor.css
	add_editor_style('assets/css/editor.css');
}
add_action('after_setup_theme', 'uuwg_add_editor_styles');

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
