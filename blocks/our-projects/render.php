<?php

/**
 * Server-side render for uuwg/our-projects block.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
  exit;
}

require_once get_template_directory() . '/inc/template-parts.php';

// 1. Нормалізація атрибутів та дефолтні значення
$attributes         = isset($attributes) && is_array($attributes) ? $attributes : [];
$per_page           = (int) ($attributes['countOfProjects'] ?? 6);
$show_header_button = (bool) ($attributes['showHeaderButton'] ?? true);
$show_pagination    = (bool) ($attributes['showPagination'] ?? true);
$button_text        = $attributes['buttonText'] ?? 'View all projects';
$small_button_text  = $attributes['smallButtonText'] ?? 'Read more';
$heading            = $attributes['heading'] ?? '';
$button_url         = $attributes['buttonUrl'] ?? '#';

// 2. Визначення режиму та параметрів запиту
$is_all_projects = ($per_page === -1);
$posts_per_page  = $is_all_projects ? -1 : 6;

$query = new WP_Query([
  'post_type'      => 'project',
  'post_status'    => 'publish',
  'posts_per_page' => $posts_per_page,
  'paged'          => 1,
]);

$total_projects = (int) $query->found_posts;

// 3. Хелпер для виводу карток
$render_project_items = function () use ($query, $small_button_text) {
  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      echo uuwg_render_project_card(get_the_ID(), $small_button_text);
    }
  } else {
    echo '<p class="uuwg-our-projects__empty">' . esc_html__('No projects found.', 'uuwg') . '</p>';
  }
};
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-our-projects alignfull']); ?>>
  <div class="uuwg-our-projects__content">

    <!-- Шапка блоку -->
    <div class="uuwg-our-projects__header">
      <div class="uuwg-our-projects__header-top">
        <h2 class="uuwg-our-projects__heading">
          <?php echo esc_html($heading); ?>
        </h2>

        <?php if ($show_header_button && ! empty($button_text)) : ?>
        <a class="uuwg-our-projects__cta wp-element-button uuwg-btn" href="<?php echo esc_url($button_url); ?>">
          <?php echo esc_html($button_text); ?>
        </a>
        <?php endif; ?>
      </div>

      <!-- Перемикач фільтрів рендериться лише якщо завантажуються всі проєкти ($per_page === -1) -->
      <?php if ($is_all_projects) : ?>
      <details id="uuwg-project-filter" class="uuwg-our-projects__filters js-projects-filters">
        <summary value="all" class="uuwg-projects-filter__current" data-filter="featured" aria-label="Projects filter">
          <?php esc_html_e('Featured projects', 'uuwg'); ?>
        </summary>
        <ul class="uuwg-projects-filter__list">
          <li value="all" class="uuwg-projects-filter__item" data-filter="all">
            <?php esc_html_e('All projects', 'uuwg'); ?>
          </li>
          <li value="featured" class="uuwg-projects-filter__item is-active" selected data-filter="featured">
            <?php esc_html_e('Featured projects', 'uuwg'); ?>
          </li>
          <li value="passed" class="uuwg-projects-filter__item" data-filter="passed">
            <?php esc_html_e('Past projects', 'uuwg'); ?>
          </li>
        </ul>

      </details>
      <?php endif; ?>
    </div>

    <!-- Контентна сітка або Карусель -->
    <?php if ($is_all_projects) : ?>

    <div class="uuwg-our-projects__grids js-projects-grid-all">
      <?php $render_project_items(); ?>
    </div>

    <?php else : ?>

    <div class="uuwg-our-projects__grids uuwg-carousel js-projects-grid" data-uuwg-carousel data-carousel-desktop="3"
      data-carousel-tablet="2" data-carousel-mobile="1"
      data-show-pagination="<?php echo $show_pagination ? 'true' : 'false'; ?>" data-uuwg-pagination
      data-post-type="project" data-per-page="<?php echo esc_attr($per_page); ?>"
      data-small-button-text="<?php echo esc_attr($small_button_text); ?>"
      data-total-items="<?php echo esc_attr($total_projects); ?>">

      <div class="uuwg-carousel__track">
        <?php $render_project_items(); ?>
      </div>

      <?php if ($show_pagination) : ?>
      <div class="uuwg-carousel__pagination"></div>
      <?php endif; ?>

    </div>

    <?php endif; ?>

  </div>
</section>

<?php wp_reset_postdata(); ?>