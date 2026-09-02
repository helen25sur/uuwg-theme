<?php
$attributes = isset($attributes) && is_array($attributes) ? $attributes : array();
// If the button URL is not provided, we will try to get it from the site settings page (ACF Fields).
$site_settings = get_page_by_path('site-settings');
$donate_url = '';

if (function_exists('get_field') && $site_settings) {
  $donate_url = call_user_func('get_field', 'donate_url', $site_settings->ID);
}

$button_url = $attributes['buttonUrl'] ?: $donate_url;
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-values-circles alignfull']); ?>>
  <div class="uuwg-values-circles__content">
    <div class="uuwg-values-circles__header">
      <h2 class="uuwg-values-circles__heading"><?php echo esc_html($attributes['heading'] ?? ''); ?></h2>
      <p class="uuwg-values-circles__header-text"><?php echo esc_html($attributes['headerText'] ?? ''); ?></p>
      <a class="uuwg-values-circles__cta wp-element-button uuwg-btn" target="_blank" rel="noreferrer noopener"
        href="<?php echo esc_url($button_url); ?>">
        <?php echo esc_html($attributes['buttonText'] ?? ''); ?>
      </a>
    </div>

    <div class="uuwg-values-circles__grids">
      <div class="uuwg-values-circles__list">
        <?php for ($i = 1; $i <= 5; $i++) : ?>
        <div class="uuwg-values-circles__card">
          <h3 class="uuwg-values-circles__card__title"><?php echo esc_html($attributes["item{$i}Title"] ?? ''); ?></h3>
          <p class="uuwg-values-circles__card__text"><?php echo esc_html($attributes["item{$i}Text"] ?? ''); ?></p>
        </div>
        <?php endfor; ?>
      </div>
    </div>
  </div>
</section>