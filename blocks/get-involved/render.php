<?php
// Ensure $attributes is defined to avoid PHP notices when this template is rendered directly.
$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-get-involved alignfull']); ?>>
  <div class="uuwg-get-involved__content">
    <div class="uuwg-get-involved__header">
      <h2 class="uuwg-get-involved__heading"><?php echo esc_html($attributes['heading'] ?? ''); ?></h2>
    </div>

    <div class="uuwg-get-involved__grids">
      <?php for ($i = 1; $i <= 2; $i++) : ?>
      <div class="uuwg-get-involved__card">
        <h3 class="uuwg-get-involved__card__title"><?php echo esc_html($attributes["item{$i}Title"] ?? ''); ?></h3>
        <div class="uuwg-get-involved__card__text"><?php echo esc_html($attributes["item{$i}Text"] ?? ''); ?></div>
        <a href="<?php echo esc_url($attributes['buttonUrl']); ?>"
          class="uuwg-get-involved__card__cta wp-element-button"><?php echo esc_html($attributes["item{$i}ButtonText"] ?? ''); ?></a>
      </div>
      <?php endfor; ?>
    </div>
  </div>

</section>