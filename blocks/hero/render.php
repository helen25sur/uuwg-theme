<?php

if (! defined('ABSPATH')) {
  exit;
}

$title = $attributes['title'] ?? '';
$subtitle = $attributes['subtitle'] ?? '';

$yellow_button_text = $attributes['yellowButtonText'] ?? '';
$yellow_button_url = $attributes['yellowButtonUrl'] ?? '#';

$secondary_button_text = $attributes['secondaryButtonText'] ?? '';
$secondary_button_url = $attributes['secondaryButtonUrl'] ?? '#';

$background_image_url = $attributes['backgroundImageUrl'] ?? '';

$background = '';
$background_image_url = $attributes['backgroundImageUrl'] ?? '';

if ($background_image_url) {
  $background = sprintf(
    'background-image:url(%s);',
    esc_url($background_image_url)
  );
}

$wrapper_attributes = get_block_wrapper_attributes(
  array(
    'class' => 'uuwg-hero',
    'style' => $background,
  )
);
?>
<section <?php echo $wrapper_attributes; ?>>
  <div class="uuwg-hero__container">
    <div class="uuwg-hero__inner">
      <h1 class="uuwg-hero__title"><?php echo wp_kses_post($title); ?></h1>
      <p class="uuwg-hero__subtitle"><?php echo wp_kses_post($subtitle); ?></p>
      <div class="uuwg-hero__buttons">
        <a class="uuwg-hero__button uuwg-hero__button--yellow wp-element-button" target="_blank"
          rel="noreferrer noopener" href="<?php echo esc_url($yellow_button_url); ?>">
          <?php echo esc_html($yellow_button_text); ?>
        </a>
        <a class="uuwg-hero__button uuwg-hero__button--secondary" href="<?php echo esc_url($secondary_button_url); ?>">
          <?php echo esc_html($secondary_button_text); ?>
        </a>
      </div>
    </div>
  </div>
</section>