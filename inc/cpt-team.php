<?php
/**
 * Custom Post Type: Team members.
 * Поля (посада, період роботи, соцмережі) — через ACF.
 *
 * @package UUWG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function uuwg_register_cpt_team() {
	register_post_type(
		'team_member',
		array(
			'labels'       => array(
				'name'          => __( 'Команда', 'uuwg' ),
				'singular_name' => __( 'Учасник команди', 'uuwg' ),
				'add_new_item'  => __( 'Додати учасника', 'uuwg' ),
				'edit_item'     => __( 'Редагувати учасника', 'uuwg' ),
			),
			'public'       => true,
			'show_in_rest' => true,
			'has_archive'  => false, // виводиться тільки грідом на About us, окремої архівної сторінки не треба
			'rewrite'      => array( 'slug' => 'team' ),
			'menu_icon'    => 'dashicons-groups',
			'supports'     => array( 'title', 'thumbnail' ),
		)
	);
}
add_action( 'init', 'uuwg_register_cpt_team' );
