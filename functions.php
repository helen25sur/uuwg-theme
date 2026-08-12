<?php

/**
 * UUWG theme functions and definitions.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
	exit; // Заборонити прямий доступ до файлу.
}

define('UUWG_THEME_VERSION', '0.1.0');
define('UUWG_THEME_DIR', get_template_directory());
define('UUWG_THEME_URI', get_template_directory_uri());

/**
 * Підключення окремих модулів теми.
 * Кожна тема функціоналу — в своєму файлі, а не все в functions.php.
 */
require_once UUWG_THEME_DIR . '/inc/setup.php'; // add_theme_support, meta, register_block_pattern_category
require_once UUWG_THEME_DIR . '/inc/enqueue.php'; // підключення CSS/JS
require_once UUWG_THEME_DIR . '/inc/head.php'; // підключення fonts preconnect

require_once UUWG_THEME_DIR . '/inc/acf-options.php'; // ACF Options Page

require_once UUWG_THEME_DIR . '/inc/language-switcher.php';

require_once UUWG_THEME_DIR . '/inc/cpt-projects.php';
require_once UUWG_THEME_DIR . '/inc/cpt-news.php';
require_once UUWG_THEME_DIR . '/inc/cpt-documents.php';
require_once UUWG_THEME_DIR . '/inc/cpt-team.php';
require_once UUWG_THEME_DIR . '/inc/cpt-partners.php';
require_once UUWG_THEME_DIR . '/inc/body-classes.php';

require_once UUWG_THEME_DIR . '/inc/blocks.php'; // реєстрація кастомних блоків

require_once get_template_directory() . '/inc/ajax-handlers.php';

add_filter('wp_image_editors', function ($editors) {
	return array('WP_Image_Editor_GD');
}); // WordPress на простішу бібліотеку GD

add_action('doing_it_wrong_run', function ($function_name, $message, $version) {
	if (false !== strpos($function_name, 'WP_Block_Type_Registry')) {
		error_log('=== ЗНАЙДЕНО ПОМИЛКОВИЙ ВИКЛИК БЛОКУ ===');
		$trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 10);
		foreach ($trace as $i => $step) {
			if (isset($step['file'], $step['line'])) {
				error_log("#{$i} {$step['file']} (рядок {$step['line']}) -> function: " . ($step['function'] ?? ''));
			}
		}
	}
}, 10, 3);


add_action('wp_enqueue_scripts', 'uuwg_enqueue');
