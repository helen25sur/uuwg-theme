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
$photo1_url   = $attributes['photo1Url'] ?? '';
$photo2_url   = $attributes['photo2Url'] ?? '';
$photo3_url   = $attributes['photo3Url'] ?? '';
$photo4_url   = $attributes['photo4Url'] ?? '';
$photo5_url   = $attributes['photo5Url'] ?? '';
$photo6_url   = $attributes['photo6Url'] ?? '';

$wrapper_attributes = get_block_wrapper_attributes(
  array(
    'class' => 'uuwg-hero-about-us'
  )
);
?>
<section <?php echo $wrapper_attributes; ?>>
  <div class="uuwg-hero-about-us__container">
    <div class="uuwg-hero-about-us__inner">
      <h1 class="uuwg-hero-about-us__title"><?php echo wp_kses_post($title); ?></h1>
      <p class="uuwg-hero-about-us__subtitle"><?php echo wp_kses_post($subtitle); ?></p>
      <div class="uuwg-hero-about-us__buttons">
        <a class="uuwg-hero-about-us__button uuwg-hero-about-us__button--yellow wp-element-button" target="_blank"
          rel="noreferrer noopener" href="<?php echo esc_url($yellow_button_url); ?>">
          <?php echo esc_html($yellow_button_text); ?>
        </a>
        <a class="uuwg-hero-about-us__button uuwg-hero-about-us__button--secondary"
          href="<?php echo esc_url($secondary_button_url); ?>">
          <?php echo esc_html($secondary_button_text); ?>
        </a>
      </div>
    </div>
    <div class="uuwg-hero-about-us__photos">
      <div class="uuwg-hero-about-us__photo uuwg-hero-about-us__photo--1">
        <img src="<?php echo esc_url($photo1_url); ?>" />
      </div>

      <div class="uuwg-hero-about-us__photo uuwg-hero-about-us__photo--2">
        <img src="<?php echo esc_url($photo2_url); ?>" />
      </div>

      <div class="uuwg-hero-about-us__photo uuwg-hero-about-us__photo--3">
        <img src="<?php echo esc_url($photo3_url); ?>" />
      </div>

      <div class="uuwg-hero-about-us__photo uuwg-hero-about-us__photo--4">
        <img src="<?php echo esc_url($photo4_url); ?>" />
      </div>

      <div class="uuwg-hero-about-us__photo uuwg-hero-about-us__photo--5">
        <img src="<?php echo esc_url($photo5_url); ?>" />
      </div>

      <div class="uuwg-hero-about-us__photo uuwg-hero-about-us__photo--6">
        <img src="<?php echo esc_url($photo6_url); ?>" />
      </div>
    </div>
  </div>
</section>