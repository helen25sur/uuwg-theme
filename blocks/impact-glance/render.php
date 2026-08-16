<?php
// Ensure $attributes is defined to avoid PHP notices when this template is rendered directly.
$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-impact-glance alignfull']); ?>>
  <div class="uuwg-impact-glance__content">
    <div class="uuwg-impact-glance__header">
      <h2 class="uuwg-impact-glance__heading"><?php echo esc_html($attributes['heading'] ?? ''); ?></h2>
      <p class="uuwg-impact-glance__header-text"><?php echo esc_html($attributes['headerText'] ?? ''); ?></p>
      <a class="uuwg-impact-glance__cta wp-element-button" href="<?php echo esc_url($attributes['buttonUrl']); ?>"
        class="uuwg-btn">
        <?php echo esc_html($attributes['buttonText']); ?>
      </a>
    </div>

    <div class="uuwg-impact-glance__grids">
      <?php for ($i = 1; $i <= 4; $i++) : ?>
        <div class="uuwg-impact-glance__card">
          <h3 class="uuwg-impact-glance__card__title"><?php echo esc_html($attributes["item{$i}Title"] ?? ''); ?></h3>
          <p class="uuwg-impact-glance__card__text"><?php echo esc_html($attributes["item{$i}Text"] ?? ''); ?></p>
        </div>
      <?php endfor; ?>
    </div>
  </div>

</section>