<?php
/**
 * Custom Post Type: News & Events.
 * Поле "Дата події/публікації" — через ACF Date Picker (окремо від стандартної
 * дати запису WP, бо подія й дата публікації можуть відрізнятись).
 *
 * @package UUWG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function uuwg_register_cpt_news() {
	register_post_type(
		'news_event',
		array(
			'labels'       => array(
				'name'          => __( 'Новини та події', 'uuwg' ),
				'singular_name' => __( 'Новина', 'uuwg' ),
				'add_new_item'  => __( 'Додати новину', 'uuwg' ),
				'edit_item'     => __( 'Редагувати новину', 'uuwg' ),
			),
			'public'       => true,
			'show_in_rest' => true,
			'has_archive'  => true,
			'rewrite'      => array( 'slug' => 'news' ),
			'menu_icon'    => 'dashicons-megaphone',
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		)
	);
}
add_action( 'init', 'uuwg_register_cpt_news' );
