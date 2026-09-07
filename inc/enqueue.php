<?php

/**
 * Enqueue theme styles and scripts.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
	exit;
}

/**
 * Enqueue Google Fonts.
 */
function uuwg_enqueue()
{
	wp_enqueue_style(
		'uuwg-fonts',
		'https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap',
		array(),
		null
	);
}

add_action('wp_enqueue_scripts', 'uuwg_enqueue');


/**
 * Enqueue frontend styles and scripts.
 */
function uuwg_enqueue_assets()
{
	/*
	 * Main styles.
	 */
	$style_path = UUWG_THEME_DIR . '/style.css';

	wp_enqueue_style(
		'uuwg-style',
		UUWG_THEME_URI . '/style.css',
		array(),
		file_exists($style_path) ? filemtime($style_path) : UUWG_THEME_VERSION
	);

	$main_style_path = UUWG_THEME_DIR . '/assets/css/main.css';

	wp_enqueue_style(
		'uuwg-main-style',
		UUWG_THEME_URI . '/assets/css/main.css',
		array(),
		file_exists($main_style_path) ? filemtime($main_style_path) : UUWG_THEME_VERSION
	);


	/*
	 * Message popup.
	 */
	$message_popup_path = UUWG_THEME_DIR . '/assets/js/message-popup.js';

	wp_enqueue_script(
		'uuwg-message-popup',
		UUWG_THEME_URI . '/assets/js/message-popup.js',
		array(),
		file_exists($message_popup_path) ? filemtime($message_popup_path) : UUWG_THEME_VERSION,
		true
	);


	/*
	 * Navigation.
	 */
	$navigation_path = UUWG_THEME_DIR . '/assets/js/navigation.js';

	wp_enqueue_script(
		'uuwg-navigation',
		UUWG_THEME_URI . '/assets/js/navigation.js',
		array(),
		file_exists($navigation_path) ? filemtime($navigation_path) : UUWG_THEME_VERSION,
		true
	);


	/*
	 * Scroll animations.
	 */
	$scroll_path = UUWG_THEME_DIR . '/assets/js/scroll.js';

	wp_enqueue_script(
		'uuwg-scroll-js',
		UUWG_THEME_URI . '/assets/js/scroll.js',
		array(),
		file_exists($scroll_path) ? filemtime($scroll_path) : UUWG_THEME_VERSION,
		true
	);


	/*
	 * Pagination is currently used only on the front page.
	 */
	if (is_front_page()) {
		$pagination_path = UUWG_THEME_DIR . '/assets/js/pagination.js';

		wp_enqueue_script(
			'uuwg-pagination-js',
			UUWG_THEME_URI . '/assets/js/pagination.js',
			array(),
			file_exists($pagination_path) ? filemtime($pagination_path) : UUWG_THEME_VERSION,
			true
		);
	}


	/*
	 * Document filters.
	 */
	$filter_documents_path = UUWG_THEME_DIR . '/assets/js/filter-documents.js';

	wp_enqueue_script(
		'uuwg-filter-documents',
		UUWG_THEME_URI . '/assets/js/filter-documents.js',
		array(),
		file_exists($filter_documents_path) ? filemtime($filter_documents_path) : UUWG_THEME_VERSION,
		true
	);


	/*
	 * Project filters.
	 */
	$filter_projects_path = UUWG_THEME_DIR . '/assets/js/filter-projects.js';

	wp_enqueue_script(
		'uuwg-filter-projects',
		UUWG_THEME_URI . '/assets/js/filter-projects.js',
		array(),
		file_exists($filter_projects_path) ? filemtime($filter_projects_path) : UUWG_THEME_VERSION,
		true
	);

	/*
	 * Validation contact form.
	 */
	$contact_us_path = UUWG_THEME_DIR . '/assets/js/contact-us-form.js';

	wp_enqueue_script(
		'uuwg-contact-us-form',
		UUWG_THEME_URI . '/assets/js/contact-us-form.js',
		array(),
		file_exists($contact_us_path) ? filemtime($contact_us_path) : UUWG_THEME_VERSION,
		true
	);

	/*
	 * Add header active class script.
	 */
	$header_active_class_path = UUWG_THEME_DIR . '/assets/js/header-active-class.js';

	wp_enqueue_script(
		'uuwg-header-active-class',
		UUWG_THEME_URI . '/assets/js/header-active-class.js',
		array(),
		file_exists($header_active_class_path) ? filemtime($header_active_class_path) : UUWG_THEME_VERSION,
		true
	);
}

add_action('wp_enqueue_scripts', 'uuwg_enqueue_assets');


/**
 * Enable editor styles.
 */
function uuwg_add_editor_styles()
{
	add_theme_support('editor-styles');
	add_editor_style('assets/css/editor.css');
}

add_action('after_setup_theme', 'uuwg_add_editor_styles');


/**
 * Pass theme data to block editor JavaScript.
 */
function uuwg_localize_block_editor_assets()
{
	wp_add_inline_script(
		'wp-blocks',
		'window.uuwgThemeData = ' . wp_json_encode(
			array(
				'themeUri' => get_template_directory_uri(),
			)
		) . ';',
		'before'
	);
}

add_action(
	'enqueue_block_editor_assets',
	'uuwg_localize_block_editor_assets'
);


/**
 * Enqueue GSAP animation for the About page.
 */
function uuwg_enqueue_values_animation()
{
	if (! is_page('about')) {
		return;
	}

	wp_enqueue_script(
		'gsap',
		'https://cdn.jsdelivr.net/npm/gsap@3.15.0/dist/gsap.min.js',
		array(),
		'3.15.0',
		true
	);

	wp_enqueue_script(
		'gsap-scrolltrigger',
		'https://cdn.jsdelivr.net/npm/gsap@3.15.0/dist/ScrollTrigger.min.js',
		array('gsap'),
		'3.15.0',
		true
	);

	$animation_path = UUWG_THEME_DIR . '/assets/js/values-animation.js';

	if (! file_exists($animation_path)) {
		return;
	}

	wp_enqueue_script(
		'uuwg-values-animation',
		UUWG_THEME_URI . '/assets/js/values-animation.js',
		array('gsap', 'gsap-scrolltrigger'),
		filemtime($animation_path),
		true
	);
}

add_action('wp_enqueue_scripts', 'uuwg_enqueue_values_animation');
