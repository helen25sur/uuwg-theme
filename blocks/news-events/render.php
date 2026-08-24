<?php

/**
 * Server-side render for uuwg/news-events block.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
  exit;
}

require_once get_template_directory() . '/inc/template-parts.php';

$attributes = isset($attributes) && is_array($attributes) ? $attributes : [];

$count = isset($attributes['countOfNews'])
  ? (int) $attributes['countOfNews']
  : 3;

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


// Визначення режиму та параметрів запиту.

$is_all_news = ($count === -1);
$posts_per_page = $is_all_news ? -1 : $count;


// Основний запит.

$query = new WP_Query([
  'post_type'      => 'news_event',
  'post_status'    => 'publish',
  'posts_per_page' => $posts_per_page,
  'paged'          => 1,
]);

$total_items = (int) $query->found_posts;


// Хелпер для виводу карток.

$render_news_items = function () use ($query, $small_button_text) {

  if ($query->have_posts()) {

    while ($query->have_posts()) {
      $query->the_post();

      echo uuwg_render_news_card(
        get_the_ID(),
        $small_button_text
      );
    }
  } else {

    echo '<p class="uuwg-news-events__empty">'
      . esc_html__('No news & events found.', 'uuwg')
      . '</p>';
  }
};

?>

<section
  <?php
  echo get_block_wrapper_attributes([
    'class' => 'uuwg-news-events alignfull',
  ]);
  ?>
  data-count="<?php echo esc_attr($count); ?>"
  data-ajax-url="<?php echo esc_url(admin_url('admin-ajax.php')); ?>">
  <div class="uuwg-news-events__content">

    <!-- Шапка блоку -->

    <div class="uuwg-news-events__header">

      <?php if (! empty($heading)) : ?>

        <h2 class="uuwg-news-events__heading">
          <?php echo esc_html($heading); ?>
        </h2>

      <?php endif; ?>


      <?php if ($show_header_button && ! empty($button_text)) : ?>

        <a
          href="<?php echo esc_url($button_url ?: '#'); ?>"
          class="uuwg-news-events__cta uuwg-btn wp-element-button">
          <?php echo esc_html($button_text); ?>
        </a>

      <?php endif; ?>

    </div>


    <!-- Контентна сітка або карусель -->

    <?php if ($is_all_news) : ?>

      <div class="uuwg-news-events__grids js-news-grid-all">
        <?php $render_news_items(); ?>
      </div>

    <?php else : ?>

      <div
        class="uuwg-news-events__grids js-news-grid uuwg-carousel"
        data-uuwg-carousel
        data-carousel-desktop="3"
        data-carousel-tablet="2"
        data-carousel-mobile="1"
        data-show-pagination="<?php echo $show_pagination ? 'true' : 'false'; ?>"
        data-uuwg-pagination
        data-post-type="news_event"
        data-per-page="<?php echo esc_attr($count); ?>"
        data-total-items="<?php echo esc_attr($total_items); ?>">

        <div class="uuwg-carousel__track">
          <?php $render_news_items(); ?>
        </div>

        <?php if ($show_pagination) : ?>

          <div class="uuwg-carousel__pagination"></div>

        <?php endif; ?>

      </div>

    <?php endif; ?>

  </div>
</section>

<?php wp_reset_postdata(); ?>