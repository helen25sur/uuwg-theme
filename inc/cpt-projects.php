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
			'has_archive'        => false,
			'rewrite'            => array(
				'slug' => 'project',
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

// inc/cpt-projects.php — примусово одна категорія на проєкт
function uuwg_force_single_project_category($post_id, $terms, $tt_ids, $taxonomy)
{
	if ('project_category' !== $taxonomy || count($terms) <= 1) {
		return;
	}
	// Лишаємо тільки останній щойно доданий термін
	$latest_term = end($terms);
	wp_set_object_terms($post_id, $latest_term, $taxonomy);
}
add_action('set_object_terms', 'uuwg_force_single_project_category', 10, 4);

/**
 * Додає колонку "Категорія" в список Projects в адмінці.
 */
function uuwg_add_project_category_column($columns)
{
	// Вставляємо нову колонку одразу після Title, а не в кінець списку
	$new_columns = array();
	foreach ($columns as $key => $label) {
		$new_columns[$key] = $label;
		if ('title' === $key) {
			$new_columns['project_category'] = __('Category', 'uuwg');
		}
	}
	return $new_columns;
}
add_filter('manage_project_posts_columns', 'uuwg_add_project_category_column');

/**
 * Виводить обрані терміни project_category у відповідній колонці.
 */
function uuwg_render_project_category_column($column, $post_id)
{
	if ('project_category' !== $column) {
		return;
	}

	$terms = get_the_terms($post_id, 'project_category');

	if (empty($terms) || is_wp_error($terms)) {
		echo '<span style="color:#a7aaad;">—</span>';
		return;
	}

	$term_links = array();
	foreach ($terms as $term) {
		$edit_link    = get_edit_term_link($term->term_id, 'project_category', 'project');
		$term_links[] = sprintf(
			'<a href="%s">%s</a>',
			esc_url($edit_link),
			esc_html($term->name)
		);
	}

	echo wp_kses_post(implode(', ', $term_links));
}
add_action('manage_project_posts_custom_column', 'uuwg_render_project_category_column', 10, 2);

/**
 * Робить нову колонку сортовуваною (клік на заголовок "Category").
 */
function uuwg_project_category_sortable_column($columns)
{
	$columns['project_category'] = 'project_category';
	return $columns;
}
add_filter('manage_edit-project_sortable_columns', 'uuwg_project_category_sortable_column');
