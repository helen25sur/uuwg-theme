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

require_once UUWG_THEME_DIR . '/inc/acf-options.php'; // ACF Options Page

require_once UUWG_THEME_DIR . '/inc/cpt-projects.php';
require_once UUWG_THEME_DIR . '/inc/cpt-news.php';
require_once UUWG_THEME_DIR . '/inc/cpt-documents.php';
require_once UUWG_THEME_DIR . '/inc/cpt-team.php';
require_once UUWG_THEME_DIR . '/inc/cpt-partners.php';

require_once UUWG_THEME_DIR . '/inc/blocks.php'; // реєстрація кастомних блоків