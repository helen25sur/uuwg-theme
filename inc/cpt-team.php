<?php

/**
 * Custom Post Type: Team members.
 * Поля (посада, період роботи, соцмережі) — через ACF.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
	exit;
}

function uuwg_register_cpt_team()
{
	register_post_type(
		'team_member',
		array(
			'labels'       => array(
				'name'          => __('Team', 'uuwg'),
				'singular_name' => __('Team Member', 'uuwg'),
				'add_new_item'  => __('Add Team Member', 'uuwg'),
				'edit_item'     => __('Edit Team Member', 'uuwg'),
			),
			'public'       => true,
			'show_in_rest' => true,
			'has_archive'  => false,
			'rewrite'      => array('slug' => 'team'),
			'menu_icon'    => 'dashicons-groups',
			'supports'     => array('title', 'thumbnail'),
		)
	);
}
add_action('init', 'uuwg_register_cpt_team');


if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group(array(
		'key'                   => 'group_team_member_details',
		'title'                 => __('Information about team member', 'uuwg'),
		'fields'                => array(
			// Посада
			array(
				'key'          => 'field_team_position',
				'label'        => __('Team position', 'uuwg'),
				'name'         => 'member_position',
				'type'         => 'text',
				'placeholder'  => 'for example: Founder, CEO, Assistant',
				'required'     => 1,
			),
			// Період роботи
			array(
				'key'          => 'field_team_period',
				'label'        => __('Work period', 'uuwg'),
				'name'         => 'member_period',
				'type'         => 'text',
				'placeholder'  => 'for example: 2024 - now',
				'required'     => 0,
			),
			// Facebook
			array(
				'key'          => 'field_team_fb',
				'label'        => __('Facebook URL', 'uuwg'),
				'name'         => 'member_fb',
				'type'         => 'url',
				'placeholder'  => 'https://facebook.com/...',
			),
			// Telegram
			array(
				'key'          => 'field_team_tg',
				'label'        => __('Telegram URL', 'uuwg'),
				'name'         => 'member_tg',
				'type'         => 'url',
				'placeholder'  => 'https://t.me/...',
			),
			// LinkedIn
			array(
				'key'          => 'field_team_linkedin',
				'label'        => __('LinkedIn URL', 'uuwg'),
				'name'         => 'member_linkedin',
				'type'         => 'url',
				'placeholder'  => 'https://linkedin.com/in/...',
			),
		),
		'location'              => array(
			array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'team_member', // Прив'язка до CPT team_member
				),
			),
		),
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
	));
}
