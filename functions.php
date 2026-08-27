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
 *
 * Кожна тема функціоналу — в своєму файлі,
 * а не все в functions.php.
 */

require_once UUWG_THEME_DIR . '/inc/setup.php';
require_once UUWG_THEME_DIR . '/inc/enqueue.php';
require_once UUWG_THEME_DIR . '/inc/head.php';

require_once UUWG_THEME_DIR . '/inc/acf-options.php';

require_once UUWG_THEME_DIR . '/inc/language-switcher.php';

require_once UUWG_THEME_DIR . '/inc/cpt-projects.php';
require_once UUWG_THEME_DIR . '/inc/cpt-news.php';
require_once UUWG_THEME_DIR . '/inc/cpt-documents.php';
require_once UUWG_THEME_DIR . '/inc/cpt-team.php';
require_once UUWG_THEME_DIR . '/inc/cpt-partners.php';
require_once UUWG_THEME_DIR . '/inc/body-classes.php';
require_once UUWG_THEME_DIR . '/inc/shortcodes.php';
require_once UUWG_THEME_DIR . '/inc/pagination.php';
require_once UUWG_THEME_DIR . '/inc/filters.php';

require_once UUWG_THEME_DIR . '/inc/blocks.php';

require_once UUWG_THEME_DIR . '/inc/ajax-handlers.php';

// add_filter('wp_image_editors', function ($editors) {
// 	return array('WP_Image_Editor_GD');
// }); // WordPress на простішу бібліотеку GD