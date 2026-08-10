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

if (! defined('ABSPATH')) {
	exit;
}

// function uuwg_register_blocks()
// {
// 	$blocks_dir = UUWG_THEME_DIR . '/blocks';

// 	if (! is_dir($blocks_dir)) {
// 		return;
// 	}


// 	foreach (glob($blocks_dir . '/*', GLOB_ONLYDIR) as $block_path) {
// 		if (file_exists($block_path . '/block.json')) {
// 			$result = register_block_type($block_path);

// 			echo '<!-- BLOCK REGISTERED: ' . basename($block_path) . ' -->';

// 			if ($result) {
// 				error_log('UUWG BLOCK REGISTERED: ' . $result->name);
// 			}
// 		}
// 	}
// }
// add_action('init', 'uuwg_register_blocks');

// function uuwg_register_logo_block()
// {
// 	register_block_type(get_template_directory() . '../blocks/uuwg-logo');
// }
// add_action('init', 'uuwg_register_logo_block');

add_action('init', 'uuwg_register_blocks');
function uuwg_register_blocks()
{
	register_block_type(get_template_directory() . '/blocks/uuwg-logo');
	register_block_type(get_template_directory() . '/blocks/hero');
	register_block_type(get_template_directory() . '/blocks/mission');
	register_block_type(get_template_directory() . '/blocks/what-we-do');
}
