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

$count = isset($attributes['countOfNews'])
  ? intval($attributes['countOfNews'])
  : 3;
$initial_load = 6;

$button_url = $attributes['buttonUrl'] ?? '#';
$button_text = $attributes['buttonText'] ?? 'View more';
$small_button_text = $attributes['smallButtonText'] ?? 'Read more';
$heading = $attributes['heading'] ?? '';

$show_pagination = isset($attributes['showPagination'])
  ? (bool) $attributes['showPagination']
  : true;

$show_header_button = isset($attributes['showHeaderButton'])
  ? (bool) $attributes['showHeaderButton']
  : true;


/*
 * Get total number of news/events.
 *
 * This is used by carousel.js to calculate
 * the total number of pagination pages.
 */
$total_news_query = new WP_Query([
  'post_type'      => 'news_event',
  'posts_per_page' => 1,
  'post_status'    => 'publish',
  'fields'         => 'ids',
]);

$total_items = $total_news_query->found_posts;


/*
 * Initial page.
 *
 * Only $count news/events are rendered by PHP.
 * Additional items are loaded by pagination.js.
 */
$query = new WP_Query([
  'post_type'      => 'news_event',
  'posts_per_page' => $initial_load,
  'paged'          => 1,
  'post_status'    => 'publish',
]);
?>

<section <?php echo get_block_wrapper_attributes([
            'class' => 'uuwg-news-events alignfull'
          ]); ?> data-count="<?php echo esc_attr($count); ?>"
  data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">

  <div class="uuwg-news-events__content">

    <div class="uuwg-news-events__header">

      <?php if (! empty($heading)) : ?>

      <h2 class="uuwg-news-events__heading">
        <?php echo esc_html($heading); ?>
      </h2>

      <?php endif; ?>


      <?php if ($show_header_button && ! empty($button_text)) : ?>

      <a href="<?php echo esc_url($button_url ?: '#'); ?>" class="uuwg-news-events__cta uuwg-btn wp-element-button">
        <?php echo esc_html($button_text); ?>
      </a>

      <?php endif; ?>

    </div>


    <div class="uuwg-news-events__grids js-news-grid uuwg-carousel" data-uuwg-carousel data-carousel-desktop="3"
      data-carousel-tablet="2" data-carousel-mobile="1"
      data-show-pagination="<?php echo $show_pagination ? 'true' : 'false'; ?>" data-uuwg-pagination
      data-post-type="news_event" data-per-page="6" data-total-items="<?php echo esc_attr($total_items); ?>">

      <div class="uuwg-carousel__track">

        <?php if ($query->have_posts()) : ?>

        <?php while ($query->have_posts()) : $query->the_post();

            $ID = get_the_ID();

            $short_description = function_exists('get_field')
              ? get_field('news_short_description', $ID)
              : '';

          ?>

        <div class="uuwg-news-events__card uuwg-carousel__item">

          <a class="uuwg-news-events__permalink" href="<?php echo esc_url(get_permalink($ID)); ?>">

            <?php if (has_post_thumbnail()) : ?>

            <?php the_post_thumbnail('medium'); ?>

            <?php endif; ?>


            <div class="uuwg-news-events__card__content">

              <h3 class="uuwg-news-events__card__title">
                <?php echo esc_html(get_the_title()); ?>
              </h3>


              <?php if ($short_description) : ?>

              <p class="uuwg-news-events__card__short-description">
                <?php echo esc_html($short_description); ?>
              </p>

              <?php endif; ?>


              <span class="uuwg-news-events__card__button">
                <?php echo esc_html($small_button_text); ?>
              </span>

            </div>

          </a>

        </div>

        <?php endwhile; ?>

        <?php endif; ?>

      </div>


      <?php if ($show_pagination) : ?>

      <div class="uuwg-carousel__pagination"></div>

      <?php endif; ?>

    </div>

  </div>

</section>

<?php wp_reset_postdata(); ?>