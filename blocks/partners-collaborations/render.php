<?php

/**
 * Server-side render for uuwg/partners-collaborations block.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
  exit;
}

// Ensure $attributes is defined to avoid PHP notices.
$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);

$query = new WP_Query(array(
  'post_type'      => 'partner',
  'posts_per_page' => -1,
));
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-partners-collaborations']); ?>>
  <div class="uuwg-partners-collaborations__content">

    <div class="uuwg-partners-collaborations__header">
      <?php if (! empty($attributes['heading'])) : ?>
      <h2 class="uuwg-partners-collaborations__heading"><?php echo esc_html($attributes['heading']); ?></h2>
      <?php endif; ?>

      <?php if (! empty($attributes['headerText'])) : ?>
      <p class="uuwg-partners-collaborations__header-text"><?php echo esc_html($attributes['headerText']); ?></p>
      <?php endif; ?>
    </div>

    <div class="uuwg-partners-collaborations__row">
      <?php
      if ($query->have_posts()) :
        // Запускаємо цикл двічі для безперервної анімації
        for ($i = 0; $i < 2; $i++) :
          while ($query->have_posts()) : $query->the_post();
            $ID = get_the_ID();
            $partner_url = function_exists('get_field') ? get_field('partner_url', $ID) : '';
            ?>

      <div class="uuwg-partners-collaborations__card">
        <?php if ($partner_url) : ?>
        <a href="<?php echo esc_url($partner_url); ?>" target="_blank" rel="noopener noreferrer">
          <div class="uuwg-partners-collaborations__logo">
            <?php the_post_thumbnail('medium'); ?>
          </div>
        </a>
        <?php else : ?>
        <div class="uuwg-partners-collaborations__logo">
          <?php the_post_thumbnail('medium'); ?>
        </div>
        <?php endif; ?>
      </div>

      <?php
          endwhile;

          // Скидаємо внутрішній покажчик запиту на початок для другого прогону
          $query->rewind_posts();
        endfor;

        // Обов'язково скидаємо глобальний $post
        wp_reset_postdata();
      endif;
      ?>
    </div>

    <?php if (! empty($attributes['buttonText'])) : ?>
    <a href="<?php echo esc_url($attributes['buttonUrl'] ?? '#'); ?>"
      class="uuwg-partners-collaborations__cta uuwg-btn">
      <?php echo esc_html($attributes['buttonText']); ?>
    </a>
    <?php endif; ?>

  </div>
</section>