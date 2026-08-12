<?php

/**
 * Custom Post Type: News & Events.
 * Поле "Дата події/публікації" — через ACF Date Picker (окремо від стандартної
 * дати запису WP, бо подія й дата публікації можуть відрізнятись).
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
	exit;
}

function uuwg_register_cpt_news()
{
	register_post_type(
		'news_event',
		array(
			'labels'       => array(
				'name'          => __('News & Events', 'uuwg'),
				'singular_name' => __('News', 'uuwg'),
				'add_new_item'  => __('Add News', 'uuwg'),
				'edit_item'     => __('Edit News', 'uuwg'),
				'new_item'           => __('News', 'uuwg'),
				'view_item'          => __('View New', 'uuwg'),
				'search_items'       => __('Search News', 'uuwg'),
				'not_found'          => __('No News found', 'uuwg'),
				'not_found_in_trash' => __('No News found in Trash', 'uuwg'),
			),
			'public'       => true,
			'show_in_rest' => true,
			'show_ui'      => true,
			'has_archive'  => true,
			'rewrite'      => array('slug' => 'news'),
			'menu_icon'    => 'dashicons-megaphone',
			'supports'     => array('title', 'editor', 'thumbnail', 'excerpt'),
		)
	);
}
add_action('init', 'uuwg_register_cpt_news');
