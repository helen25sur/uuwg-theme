<?php
/**
 * Реєстрація кастомних блоків теми.
 *
 * Структура: кожен блок живе у власній папці /blocks/{block-name}/
 * з block.json + render.php (+ style.css, index.js за потреби).
 * Список блоків з ТЗ (≈10 шт.):
 *   hero, mission, what-we-do, focus-areas, impact-glance,
 *   donate-cta, projects-slider, partners-logos, get-involved,
 *   card (project/news/document — уніфікований з варіаціями),
 *   team-card, values-circles, filter-dropdown.
 *
 * @package UUWG
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function uuwg_register_blocks() {
	$blocks_dir = UUWG_THEME_DIR . '/blocks';

	if ( ! is_dir( $blocks_dir ) ) {
		return;
	}

	foreach ( glob( $blocks_dir . '/*', GLOB_ONLYDIR ) as $block_path ) {
		if ( file_exists( $block_path . '/block.json' ) ) {
			register_block_type( $block_path );
		}
	}
}
add_action( 'init', 'uuwg_register_blocks' );
