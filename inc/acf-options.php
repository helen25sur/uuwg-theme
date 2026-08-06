<?php
/**
 * ACF Options Page: глобальні налаштування, що використовуються
 * в кількох блоках/шаблонах одночасно (контакти, соцмережі,
 * Impact-цифри, Donate URL, Mailchimp).
 *
 * Потребує активного плагіна Advanced Custom Fields (Pro для Options Page).
 *
 * @package UUWG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( function_exists( 'acf_add_options_page' ) ) {
	acf_add_options_page(
		array(
			'page_title' => __( 'Налаштування сайту', 'uuwg' ),
			'menu_title' => __( 'Налаштування UUWG', 'uuwg' ),
			'menu_slug'  => 'uuwg-settings',
			'capability' => 'edit_posts',
			'icon_url'   => 'dashicons-admin-settings',
			'redirect'   => false,
		)
	);
}

/**
 * Поля цієї сторінки (контакти, соцмережі, Impact-цифри, Donate URL,
 * Mailchimp) реєструються через ACF JSON у /acf-json/ — синхронізуй
 * їх у ACF → Tools → Sync після клонування репозиторію на новому середовищі.
 */
