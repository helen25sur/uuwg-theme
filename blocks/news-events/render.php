<?php

/**
 * Server-side render for uuwg/news-events block.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
  exit;
}

$attributes = isset($attributes) && is_array($attributes) ? $attributes : [];
$count = isset($attributes['countOfNews']) ? intval($attributes['countOfNews']) : 3;
$button_url = $attributes['buttonUrl'] ?? '#';
$button_text = $attributes['buttonText'] ?? 'View more';
$small_button_text = $attributes['smallButtonText'] ?? 'Read more';
$heading = $attributes['heading'] ?? '';
$show_pagination = $attributes['showPagination'] ?? true;

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
      <?php if (! empty($heading)) : ?>
        <h2 class="uuwg-news-events__heading"><?php echo esc_html($heading); ?></h2>
      <?php endif; ?>

      <a class="uuwg-news-events__cta uuwg-btn" href="<?php echo esc_url($button_url); ?>">
        <?php echo esc_html($button_text); ?>
      </a>
    </div>

    <div class="uuwg-news-events__grids js-news-grid">
      <?php if ($query->have_posts()) : ?>
        <?php while ($query->have_posts()) : $query->the_post();
          $ID = get_the_ID();
          $short_description = function_exists('get_field') ? get_field('news_short_description', $ID) : '';
        ?>
          <div class="uuwg-news-events__card">
            <a class="uuwg-news-events__permalink" href="<?php echo esc_url(get_permalink($ID)); ?>">
              <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('medium'); ?>
              <?php endif; ?>

              <div class="uuwg-news-events__card__content">
                <h3 class="uuwg-news-events__card__title"><?php echo esc_html(get_the_title()); ?></h3>

                <?php if ($short_description) : ?>
                  <p class="uuwg-news-events__card__short-description"><?php echo esc_html($short_description); ?></p>
                <?php endif; ?>

                <span class="uwg-news-events__card__button"><?php echo esc_html($small_button_text); ?></span>
              </div>
            </a>
          </div>
        <?php endwhile; ?>
      <?php endif; ?>
    </div>

    <?php if ($show_pagination && $query->max_num_pages > 1) : ?>
      <div class="uuwg-news-events__pagination js-news-pagination">
        <?php for ($i = 1; $i <= $query->max_num_pages; $i++) : ?>
          <button type="button" class="uuwg-pagination-news-btn <?php echo $i === 1 ? 'is-active' : ''; ?>"
            data-page="<?php echo $i; ?>">
            <?php echo $i; ?>
          </button>
        <?php endfor; ?>
      </div>
    <?php endif; ?>
  </div>

  <?php wp_reset_postdata(); ?>
</section>