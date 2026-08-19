<?php
// Ensure $attributes is defined to avoid PHP notices when this template is rendered directly.
$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-values-circles alignfull']); ?>>
  <div class="uuwg-values-circles__content">
    <div class="uuwg-values-circles__header">
      <h2 class="uuwg-values-circles__heading"><?php echo esc_html($attributes['heading'] ?? ''); ?></h2>
      <p class="uuwg-values-circles__header-text"><?php echo esc_html($attributes['headerText'] ?? ''); ?></p>
      <a class="uuwg-values-circles__cta wp-element-button" href="<?php echo esc_url($attributes['buttonUrl']); ?>"
        class="uuwg-btn">
        <?php echo esc_html($attributes['buttonText']); ?>
      </a>
    </div>

    <div class="uuwg-values-circles__grids">
      <?php for ($i = 1; $i <= 5; $i++) : ?>
        <div class="uuwg-values-circles__card">
          <h3 class="uuwg-values-circles__card__title"><?php echo esc_html($attributes["item{$i}Title"] ?? ''); ?></h3>
          <p class="uuwg-values-circles__card__text"><?php echo esc_html($attributes["item{$i}Text"] ?? ''); ?></p>
        </div>
      <?php endfor; ?>
    </div>
  </div>

</section>