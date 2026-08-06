<?php

/**
 * Custom Post Type: Projects.
 *
 * Project content is managed through:
 * - WordPress title
 * - Featured image
 * - ACF fields (short description, additional content)
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
	exit;
}

function uuwg_register_cpt_projects()
{

	register_post_type(
		'project',
		array(
			'labels' => array(
				'name'               => __('Projects', 'uuwg'),
				'singular_name'      => __('Project', 'uuwg'),
				'menu_name'          => __('Projects', 'uuwg'),
				'add_new'            => __('Add New', 'uuwg'),
				'add_new_item'       => __('Add New Project', 'uuwg'),
				'edit_item'          => __('Edit Project', 'uuwg'),
				'new_item'           => __('New Project', 'uuwg'),
				'view_item'          => __('View Project', 'uuwg'),
				'search_items'       => __('Search Projects', 'uuwg'),
				'not_found'          => __('No projects found', 'uuwg'),
				'not_found_in_trash' => __('No projects found in Trash', 'uuwg'),
			),

			'public'             => true,
			'show_ui'            => true,
			'show_in_rest'       => true,
			'has_archive'        => true,
			'rewrite'            => array(
				'slug' => 'projects',
			),

			'menu_icon'          => 'dashicons-portfolio',
			'menu_position'      => 5,

			'supports'           => array(
				'title',
				'editor',
				'thumbnail',
			),

			'taxonomies'         => array(
				'project_category',
			),

			'template_lock'      => false,
		)
	);


	register_taxonomy(
		'project_category',
		'project',
		array(
			'labels' => array(
				'name'          => __('Project Categories', 'uuwg'),
				'singular_name' => __('Project Category', 'uuwg'),
				'search_items'  => __('Search Categories', 'uuwg'),
				'all_items'     => __('All Categories', 'uuwg'),
				'edit_item'     => __('Edit Category', 'uuwg'),
				'add_new_item'  => __('Add New Category', 'uuwg'),
			),

			'public'             => true,
			'show_in_rest'       => true, // обов'язково для Gutenberg

			'hierarchical'       => true,

			'rewrite'            => array(
				'slug' => 'project-category',
			),
		)
	);
}

add_action('init', 'uuwg_register_cpt_projects');
