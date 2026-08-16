<?php
// Ensure $attributes is defined to avoid PHP notices when this template is rendered directly.
$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-focus-area alignfull']); ?>>
  <div class="uuwg-focus-area__content">
    <div class="uuwg-focus-area__header">
      <h2 class="uuwg-focus-area__heading"><?php echo esc_html($attributes['heading'] ?? ''); ?></h2>
      <a class="uuwg-focus-area__cta wp-element-button" href="<?php echo esc_url($attributes['buttonUrl']); ?>"
        class="uuwg-btn">
        <?php echo esc_html($attributes['buttonText']); ?>
      </a>
    </div>

    <div class="uuwg-focus-area__grids uuwg-carousel" data-uuwg-carousel>
      <div class="uuwg-carousel__track">
        <?php for ($i = 1; $i <= 4; $i++) : ?>
        <div class="uuwg-focus-area__two-card uuwg-carousel__item" tabindex="0">
          <div class="uuwg-focus-area__card">
            <span class="uuwg-focus-area__card__number"><?php echo $i; ?>/</span>
            <h3 class="uuwg-focus-area__card__title"><?php echo esc_html($attributes["item{$i}Title"] ?? ''); ?></h3>
          </div>
          <div class="uuwg-focus-area__card">
            <div class="uuwg-focus-area__card__text"><?php echo wp_kses_post($attributes["item{$i}Text"] ?? ''); ?>
            </div>
          </div>
        </div>
        <?php endfor; ?>
      </div>
      <div class="uuwg-carousel__dots"></div>
    </div>
  </div>

</section>