<?php
/**
 * Custom Post Type: Documents.
 * Поля "Тип документа" і "Файл" (PDF) — через ACF. "Рік" реалізовано як
 * таксономію (не число), бо це дає готовий dropdown-фільтр без AJAX-запиту
 * по meta_query — простіше і швидше на виборці.
 *
 * @package UUWG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function uuwg_register_cpt_documents() {
	register_post_type(
		'document',
		array(
			'labels'       => array(
				'name'          => __( 'Документи', 'uuwg' ),
				'singular_name' => __( 'Документ', 'uuwg' ),
				'add_new_item'  => __( 'Додати документ', 'uuwg' ),
				'edit_item'     => __( 'Редагувати документ', 'uuwg' ),
			),
			'public'       => true,
			'show_in_rest' => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'documents' ),
			'menu_icon'    => 'dashicons-media-document',
			'supports'     => array( 'title', 'thumbnail' ),
		)
	);

	// Таксономія "Рік" — для dropdown-фільтра на сторінці Documents.
	register_taxonomy(
		'document_year',
		'document',
		array(
			'labels'       => array(
				'name'          => __( 'Рік', 'uuwg' ),
				'singular_name' => __( 'Рік', 'uuwg' ),
			),
			'public'       => true,
			'show_in_rest' => true,
			'hierarchical' => false,
			'rewrite'      => array( 'slug' => 'document-year' ),
		)
	);
}
add_action( 'init', 'uuwg_register_cpt_documents' );
