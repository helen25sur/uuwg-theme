<?php
// Ensure $attributes is defined to avoid PHP notices when this template is rendered directly.
$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);

$settings_page = get_page_by_path('site-settings');

if (!$settings_page || !function_exists('get_field')) {
  return;
}
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-impact-glance alignfull']); ?>>
  <div class="uuwg-impact-glance__content">
    <div class="uuwg-impact-glance__header">
      <h2 class="uuwg-impact-glance__heading"><?php echo esc_html($attributes['heading'] ?? ''); ?></h2>
      <p class="uuwg-impact-glance__header-text"><?php echo esc_html($attributes['headerText'] ?? ''); ?></p>
      <a class="uuwg-impact-glance__cta wp-element-button uuwg-btn"
        href="<?php echo esc_url($attributes['buttonUrl']); ?>">
        <?php echo esc_html($attributes['buttonText']); ?>
      </a>
    </div>

    <div class="uuwg-impact-glance__grids">
      <?php for ($i = 1; $i <= 4; $i++) : ?>
        <div class="uuwg-impact-glance__card">
          <h3 class="uuwg-impact-glance__card__title">
            <?php echo esc_html(get_field("impact_number_{$i}", $settings_page->ID)) . '+'; ?>
          </h3>
          <p class="uuwg-impact-glance__card__text">
            <?php echo esc_html(get_field("impact_label_{$i}", $settings_page->ID)); ?>
          </p>
        </div>
      <?php endfor; ?>
    </div>
  </div>

</section>