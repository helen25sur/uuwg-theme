<?php
/**
 * Custom Post Type: Partners.
 * Поля (логотип, посилання) — через ACF. Виводяться в секції
 * "Partners & Collaborations" на Home (якір #partners).
 *
 * @package UUWG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function uuwg_register_cpt_partners() {
	register_post_type(
		'partner',
		array(
			'labels'       => array(
				'name'          => __( 'Партнери', 'uuwg' ),
				'singular_name' => __( 'Партнер', 'uuwg' ),
				'add_new_item'  => __( 'Додати партнера', 'uuwg' ),
				'edit_item'     => __( 'Редагувати партнера', 'uuwg' ),
			),
			'public'       => true,
			'show_in_rest' => true,
			'has_archive'  => false,
			'rewrite'      => array( 'slug' => 'partners' ),
			'menu_icon'    => 'dashicons-networking',
			'supports'     => array( 'title', 'thumbnail' ),
		)
	);
}
add_action( 'init', 'uuwg_register_cpt_partners' );
