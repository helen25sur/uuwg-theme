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

$attributes = isset($attributes) && is_array($attributes)
  ? $attributes
  : (array) ($attributes ?? []);


/*
 * How many projects are loaded from the server
 * at one time.
 */
$per_page = $attributes['countOfProjects'];
$initial_load = 6;

/*
 * Block settings.
 */
$show_header_button = isset($attributes['showHeaderButton'])
  ? (bool) $attributes['showHeaderButton']
  : true;

$show_pagination = isset($attributes['showPagination'])
  ? (bool) $attributes['showPagination']
  : true;

$button_text = $attributes['buttonText'] ?? 'View all projects';


/*
 * Initial query.
 *
 * We load the first 6 projects.
 * The rest will be loaded via REST API.
 */
$query = new WP_Query([
  'post_type'      => 'project',
  'post_status'    => 'publish',
  'posts_per_page' => $initial_load,
  'paged'          => 1,
]);

/*
 * Total number of projects in the database.
 *
 * This is needed by carousel.js to know
 * how many pagination dots there should be,
 * even before all projects are loaded.
 */
$total_projects = (int) $query->found_posts;

?>

<section <?php
          echo get_block_wrapper_attributes([
            'class' => 'uuwg-our-projects alignfull',
          ]);
          ?>>

  <div class="uuwg-our-projects__content">

    <div class="uuwg-our-projects__header">

      <h2 class="uuwg-our-projects__heading">
        <?php echo esc_html($attributes['heading'] ?? ''); ?>
      </h2>

      <?php if ($show_header_button && ! empty($button_text)) : ?>

        <a class="uuwg-our-projects__cta wp-element-button uuwg-btn"
          href="<?php echo esc_url($attributes['buttonUrl'] ?? '#'); ?>">
          <?php echo esc_html($button_text); ?>
        </a>

      <?php endif; ?>

    </div>


    <div class="uuwg-our-projects__grids uuwg-carousel js-projects-grid" data-uuwg-carousel data-carousel-desktop="3"
      data-carousel-tablet="2" data-carousel-mobile="1"
      data-show-pagination="<?php echo $show_pagination ? 'true' : 'false'; ?>" data-uuwg-pagination
      data-post-type="project" data-per-page="<?php echo esc_attr($per_page); ?>"
      data-small-button-text="<?php echo esc_attr($attributes['smallButtonText'] ?? ''); ?>"
      data-total-items="<?php echo esc_attr($total_projects); ?>">

      <div class="uuwg-carousel__track">

        <?php if ($query->have_posts()) : ?>

          <?php while ($query->have_posts()) : $query->the_post(); ?>

          <?php
            $ID = get_the_ID();

            $short_description = '';

            if (function_exists('get_field')) {
              $short_description = get_field(
                'project_short_description',
                $ID
              );
            }


            echo uuwg_render_project_card($ID, $attributes['smallButtonText']);

          endwhile; ?>

        <?php else : ?>

          <p class="uuwg-our-projects__empty">
            <?php esc_html_e('No projects found.', 'uuwg'); ?>
          </p>

        <?php endif; ?>

      </div>


      <?php if ($show_pagination) : ?>

        <div class="uuwg-carousel__pagination"></div>

      <?php endif; ?>

    </div>

    <?php wp_reset_postdata(); ?>

  </div>

</section>