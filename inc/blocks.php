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
	$blocks = array(
		'uuwg-logo',
		'hero',
		'mission',
		'what-we-do',
		'focus-area',
		'impact-glance',
		'donate-fundraise',
		'our-projects',
	);

	$registry = WP_Block_Type_Registry::get_instance();

	foreach ($blocks as $block) {
		$block_path = get_template_directory() . '/blocks/' . $block;

		if (! file_exists($block_path . '/block.json')) {
			continue;
		}

		// Читаємо block.json, щоб дізнатися точне ім'я блоку
		$block_data = json_decode(file_get_contents($block_path . '/block.json'), true);
		$block_name = $block_data['name'] ?? '';

		// Якщо блок вже зареєстрований — пропускаємо його і виводимо попередження в лог
		if ($block_name && $registry->is_registered($block_name)) {
			error_log("UUWG WARNING: Block '{$block_name}' in folder '{$block}' is already registered!");
			continue;
		}

		register_block_type($block_path);
	}
}

function uuwg_ajax_get_projects()
{
	$page  = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$count = isset($_POST['count']) ? intval($_POST['count']) : 3;

	$query = new WP_Query([
		'post_type'      => 'project',
		'posts_per_page' => $count,
		'paged'          => $page,
	]);

	ob_start();

	if ($query->have_posts()) :
		while ($query->have_posts()) : $query->the_post();
			$ID = get_the_ID();
			$short_description = function_exists('get_field') ? get_field('project_short_description', $ID) : '';
?>
			<div class="uuwg-our-projects__card">
				<a class="uuwg-our-project__permalink" href="<?php echo esc_url(get_permalink($ID)); ?>">
					<?php if (has_post_thumbnail()) {
						the_post_thumbnail();
					} ?>
					<div class="uuwg-our-projects__card__content">
						<h3 class="uuwg-our-projects__card__title"><?php echo esc_html(get_the_title()); ?></h3>
						<p class="uuwg-our-projects__card__short-description"><?php echo esc_html($short_description); ?></p>
						<span class="uwg-our-projects__card__button"><?php esc_html_e('Read more', 'uuwg'); ?></span>
					</div>
				</a>
			</div>
<?php
		endwhile;
		wp_reset_postdata();
	endif;

	$cards_html = ob_get_clean();

	// Генеруємо кнопки пагінації
	ob_start();
	if ($query->max_num_pages > 1) :
		for ($i = 1; $i <= $query->max_num_pages; $i++) :
			$active_class = ($i === $page) ? ' is-active' : '';
			echo '<button class="uuwg-pagination-btn' . $active_class . '" data-page="' . $i . '">' . $i . '</button>';
		endfor;
	endif;
	$pagination_html = ob_get_clean();

	wp_send_json_success([
		'cards'      => $cards_html,
		'pagination' => $pagination_html,
	]);
}

add_action('wp_ajax_uuwg_get_projects', 'uuwg_ajax_get_projects');
add_action('wp_ajax_nopriv_uuwg_get_projects', 'uuwg_ajax_get_projects');
