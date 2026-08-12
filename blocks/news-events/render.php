<?php

/**
 * Server-side render for uuwg/news-events block.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
  exit;
}

// Ensure $attributes is defined to avoid PHP notices when this template is rendered directly.
$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);
$count = $attributes['countOfNews'] ?? 3;

$query = new WP_Query([
  'post_type'      => 'news_event',
  'posts_per_page' => $count,
  'paged'          => 1,
]);
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-news-events']); ?>
  data-count="<?php echo esc_attr($count); ?>" data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
  <div class="uuwg-news-events__content">
    <div class="uuwg-news-events__header">
      <h2 class="uuwg-news-events__heading"><?php echo esc_html($attributes['heading'] ?? ''); ?></h2>
      <a class="uuwg-news-events__cta" href="<?php echo esc_url($attributes['buttonUrl']); ?>" class="uuwg-btn">
        <?php echo esc_html($attributes['buttonText']); ?>
      </a>
    </div>
    <div class="uuwg-news-events__grids js-news-grid">
      <?php

      $query = new WP_Query(array(
        'post_type'      => 'news_event',
        'posts_per_page' => $attributes['countOfNews'],
      ));

      if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
          $ID = get_the_ID();

      ?>
          <div class="uuwg-news-events__card">
            <a class="uuwg-our-project__permalink" href="<?php echo esc_url(get_permalink($ID)) ?>">
              <?php
              $thumbnail = get_the_post_thumbnail();
              if ($thumbnail) {
                echo $thumbnail;
              }
              ?>
              <div class="uuwg-news-events__card__content">
                <h3 class="uuwg-news-events__card__title"> <?php echo esc_html(get_the_title()) ?> </h3>

                <?php
                $short_description = '';
                if (function_exists('get_field')) {
                  $short_description = get_field('project_short_description', $ID);
                }
                ?>

                <p class="uuwg-news-events__card__short-description"> <?php echo esc_html($short_description) ?> </p>
                <span class="uwg-news-events__card__button"><?php echo $attributes['smallButtonText'] ?></span>
              </div>
            </a>
          </div>
      <?php endwhile;
      endif;
      ?>
    </div>
    <!-- Контейнер для пагінації -->
    <?php if (isset($attributes['showPagination']) && $attributes['showPagination'] && $query->max_num_pages > 1) : ?>
      <div class="uuwg-news-events__pagination js-news-pagination">
        <?php for ($i = 1; $i <= $query->max_num_pages; $i++) : ?>
          <button class="uuwg-pagination-btn <?php echo $i === 1 ? 'is-active' : ''; ?>" data-page="<?php echo $i; ?>">
            <?php echo $i; ?>
          </button>
        <?php endfor; ?>
      </div>
    <?php endif; ?>
  </div>
  <?php
  wp_reset_postdata(); ?>
  </div>
</section>