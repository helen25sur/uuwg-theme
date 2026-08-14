<?php

/**
 * Server-side render for uuwg/partners-collaborations block.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
  exit;
}

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

    <?php if ($query->have_posts()) :
      $partner_count = $query->post_count;
      $card_width = (int)($attributes['cardWidth'] ?? 180);
      $gap = (int)($attributes['gap'] ?? 32);
      $single_set_width = max(1, $partner_count * ($card_width + $gap));

      // Рахуємо мінімальну кількість повторів (мінімум 2)
      $min_repeats = max(2, (int)ceil(1920 / $single_set_width) + 1);
    ?>

    <div class="uuwg-partners-collaborations__row"
      style="--repeats: <?php echo $min_repeats; ?>; --speed: <?php echo $attributes['speedOfAnimation'] . 's' ?>; gap: <?php echo $gap; ?>px">
      <?php for ($i = 0; $i < $min_repeats; $i++) :
          while ($query->have_posts()) : $query->the_post();
            $ID = get_the_ID();
            $partner_url = function_exists('get_field') ? get_field('partner_url', $ID) : '';
        ?>

      <div class="uuwg-partners-collaborations__card" style="width: <?php echo $card_width; ?>px;">
        <?php if ($partner_url) : ?>
        <a href="<?php echo esc_url($partner_url); ?>" target="_blank" rel="noopener noreferrer">
          <div class="uuwg-partners-collaborations__logo">
            <?php the_post_thumbnail('medium', array(
                      'loading' => 'eager',
                      'decoding' => 'async'
                    )); ?>
          </div>
        </a>
        <?php else : ?>
        <div class="uuwg-partners-collaborations__logo">
          <?php the_post_thumbnail('medium', array(
                    'loading' => 'eager',
                    'decoding' => 'async'
                  )); ?>
        </div>
        <?php endif; ?>
      </div>

      <?php
          endwhile;
          $query->rewind_posts();
        endfor;
        wp_reset_postdata();
        ?>
    </div>

    <?php endif; ?>

    <?php if (! empty($attributes['buttonText'])) : ?>
    <a href="<?php echo esc_url($attributes['buttonUrl'] ?? '#'); ?>"
      class="uuwg-partners-collaborations__cta uuwg-btn wp-element-button">
      <?php echo esc_html($attributes['buttonText']); ?>
    </a>
    <?php endif; ?>

  </div>
</section>