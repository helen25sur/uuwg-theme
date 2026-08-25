<?php

/**
 * Custom Post Type: Documents.
 * Поля "Тип документа" і "Файл" (PDF) — через ACF. "Рік" реалізовано як
 * таксономію (не число), бо це дає готовий dropdown-фільтр без AJAX-запиту
 * по meta_query — простіше і швидше на виборці.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
	exit;
}

function uuwg_register_cpt_documents()
{
	register_post_type(
		'document',
		array(
			'labels'       => array(
				'name'          => __('Документи', 'uuwg'),
				'singular_name' => __('Документ', 'uuwg'),
				'add_new_item'  => __('Додати документ', 'uuwg'),
				'edit_item'     => __('Редагувати документ', 'uuwg'),
			),
			'public'       => true,
			'show_in_rest' => true,
			'has_archive'  => true,
			'rewrite'      => array('slug' => 'documents'),
			'menu_icon'    => 'dashicons-media-document',
			'supports'     => array('title', 'thumbnail'),
		)
	);

	// Таксономія "Рік" — для dropdown-фільтра на сторінці Documents.
	register_taxonomy(
		'document_year',
		'document',
		array(
			'labels'       => array(
				'name'          => __('Рік', 'uuwg'),
				'singular_name' => __('Рік', 'uuwg'),
			),
			'public'       => true,
			'show_in_rest' => true,
			'hierarchical' => false,
			'rewrite'      => array('slug' => 'document-year'),
		)
	);

	// Таксономія "Тип документа" — для категоризації документів.
	register_taxonomy(
		'document_type',
		'document',
		array(
			'labels' => array(
				'name'          => __('Типи документів', 'uuwg'),
				'singular_name' => __('Тип документа', 'uuwg'),
				'add_new_item'  => __('Додати тип документа', 'uuwg'),
				'edit_item'     => __('Редагувати тип документа', 'uuwg'),
			),
			'public'       => true,
			'show_in_rest' => true,
			'hierarchical' => true,
			'rewrite'      => array('slug' => 'document-type'),
		)
	);
}
add_action('init', 'uuwg_register_cpt_documents');

/**
 * ACF-поле "Document file" для завантаження документів.
 */
function uuwg_register_documents_acf_fields()
{
	if (! function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group(array(
		'key'    => 'group_document_file',
		'title'  => __('Document file', 'uuwg'),
		'style'  => 'default',
		'position' => 'normal',
		'fields' => array(
			array(
				'key'          => 'field_document_file',
				'label'        => __('File of Document', 'uuwg'),
				'name'         => 'document_file',
				'type'         => 'file',
				'return_format' => 'array',
				'mime_types'   => 'pdf',
				'instructions' => __('Завантажте файл pdf', 'uuwg'),
				'required'     => 1
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'document',
				),
			),
		),
	));
}
add_action('acf/init', 'uuwg_register_documents_acf_fields');

add_action('rest_api_init', function () {
	register_rest_field('document', 'document_file', array(
		'get_callback' => function ($post) {
			if (function_exists('get_field')) {
				return get_field('document_file', $post['id']);
			}
			return '';
		},
		'schema' => null,
	));
});
