<?php

/**
 * Custom Post Type: Partners.
 * Поля (логотип, посилання) — через ACF. Виводяться в секції
 * "Partners & Collaborations" на Home (якір #partners).
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
	exit;
}

function uuwg_register_cpt_partners()
{
	register_post_type(
		'partner',
		array(
			'labels'       => array(
				'name'          => __('Partners', 'uuwg'),
				'singular_name' => __('Partner', 'uuwg'),
				'add_new_item'  => __('Add New Partner', 'uuwg'),
				'edit_item'     => __('Edit Partner', 'uuwg'),
				'new_item'           => __('New Partner', 'uuwg'),
				'view_item'          => __('View Partner', 'uuwg'),
				'search_items'       => __('Search Partners', 'uuwg'),
				'not_found'          => __('No partners found', 'uuwg'),
				'not_found_in_trash' => __('No partners found in Trash', 'uuwg'),
			),
			'public'       => true,
			'show_in_rest' => true,
			'show_ui'      => true,
			'has_archive'  => false,
			'rewrite'      => array('slug' => 'partner'),
			'menu_icon'    => 'dashicons-networking',
			'supports'     => array('title', 'thumbnail', 'page-attributes'),
		)
	);
}
add_action('init', 'uuwg_register_cpt_partners');
