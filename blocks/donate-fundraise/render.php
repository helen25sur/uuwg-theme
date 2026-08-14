<?php
// Ensure $attributes is defined to avoid PHP notices when this template is rendered directly.
$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-donate-fundraise alignfull']); ?>>
  <div class="uuwg-donate-fundraise__content">
    <div class="uuwg-donate-fundraise__header">
      <h2 class="uuwg-donate-fundraise__heading"><?php echo esc_html($attributes['heading'] ?? ''); ?></h2>
      <div class="uuwg-donate-fundraise__header__text"><?php echo wp_kses_post($attributes["headerText"] ?? ''); ?>
      </div>
    </div>

    <div class="uuwg-donate-fundraise__grids">
      <?php for ($i = 1; $i <= 4; $i++) : ?>
      <div class="uuwg-donate-fundraise__card">
        <p class="uuwg-donate-fundraise__card__text"><?php echo esc_html($attributes["item{$i}Text"] ?? ''); ?></p>
      </div>
      <?php endfor; ?>
    </div>
    <a class="uuwg-donate-fundraise__cta wp-element-button" target="_blank" rel="noreferrer noopener"
      href="<?php echo esc_url($attributes['buttonUrl']); ?>" class="uuwg-btn">
      <?php echo esc_html($attributes['buttonText']); ?>
    </a>
  </div>

</section>