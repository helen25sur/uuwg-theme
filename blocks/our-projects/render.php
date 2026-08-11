<?php

/**
 * Server-side render for uuwg/our-projects block.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
  exit;
}

// Ensure $attributes is defined to avoid PHP notices when this template is rendered directly.
$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-our-projects']); ?>>
  <div class="uuwg-our-projects__content">
    <div class="uuwg-our-projects__header">
      <h2 class="uuwg-our-projects__heading"><?php echo esc_html($attributes['heading'] ?? ''); ?></h2>
      <p class="uuwg-our-projects__header-text"><?php echo esc_html($attributes['headerText'] ?? ''); ?></p>
      <a class="uuwg-our-projects__cta" href="<?php echo esc_url($attributes['buttonUrl']); ?>" class="uuwg-btn">
        <?php echo esc_html($attributes['buttonText']); ?>
      </a>
    </div>
    <div class="uuwg-our-projects__grids">
      <?php

      $query = new WP_Query(array(
        'post_type'      => 'project',
        'posts_per_page' => $attributes['countOfProjects'],
      ));

      if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
          $ID = get_the_ID();

      ?>
          <div class="uuwg-our-projects__card">
            <a class="uuwg-our-project__permalink" href="<?php echo esc_url(get_permalink($ID)) ?>">
              <h2> <?php echo esc_html(get_the_title()) ?> </h2>

              <?php
              $terms = get_the_terms($ID, 'project_category');

              if ($terms && ! is_wp_error($terms)) {
                foreach ($terms as $term) {
                  $name = $term->name;
              ?>

                  <span><?php echo esc_html($name) ?> </span>

              <?php
                }
              }
              $short_description = '';
              if (function_exists('get_field')) {
                $short_description = get_field('project_short_description', $ID);
              }
              ?>

              <p> <?php echo esc_html($short_description) ?> </p>
              <?php
              $thumbnail = get_the_post_thumbnail();
              if ($thumbnail) {
                echo $thumbnail;
              }
              ?>
            </a>
          </div>
        <?php endwhile;
        ?>
    </div>
  </div>
</section>
<?php
        wp_reset_postdata();
      endif;
