<?php

/**
 * Server-side render for uuwg/mission block.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
  exit;
}

$heading     = $attributes['heading'] ?? '';
$paragraph1  = $attributes['paragraph1'] ?? '';
$paragraph2  = $attributes['paragraph2'] ?? '';
$button_text = $attributes['buttonText'] ?? '';
$button_url  = $attributes['buttonUrl'] ?? '#';

$photo1_url   = $attributes['photo1Url'] ?? '';
$photo1_badge = $attributes['photo1Badge'] ?? '';

$photo2_url   = $attributes['photo2Url'] ?? '';
$photo2_badge = $attributes['photo2Badge'] ?? '';

$photo3_url   = $attributes['photo3Url'] ?? '';

$connecting_badge_text = $attributes['connectingBadgeText'] ?? '';

// Дефолтні фото з теми, поки адмін не завантажив свої.
$defaults_base = get_template_directory_uri() . '/assets/images/mission/';
if (! $photo1_url) {
  $photo1_url = $defaults_base . 'photo-1.jpg';
}
if (! $photo2_url) {
  $photo2_url = $defaults_base . 'photo-2.jpg';
}
if (! $photo3_url) {
  $photo3_url = $defaults_base . 'photo-3.jpg';
}

$wrapper_attributes = get_block_wrapper_attributes(
  array('class' => 'uuwg-mission')
);
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput 
      ?>>

  <div class="container">
    <div class="uuwg-mission__text">
      <h2 class="uuwg-mission__heading"><?php echo wp_kses_post($heading); ?></h2>
      <p class="uuwg-mission__paragraph"><?php echo wp_kses_post($paragraph1); ?></p>
      <p class="uuwg-mission__paragraph"><?php echo wp_kses_post($paragraph2); ?></p>
      <a class="uuwg-mission__button wp-element-button" href="<?php echo esc_url($button_url); ?>">
        <?php echo esc_html($button_text); ?>
      </a>
    </div>

    <div class="uuwg-mission__collage">

      <!-- Фото 1 — верхнє ліве -->
      <div class="uuwg-mission__photo uuwg-mission__photo--1">
        <div class="uuwg-mission__photo-frame">
          <img src="<?php echo esc_url($photo1_url); ?>" alt="">
          <?php if ($photo1_badge) : ?>
        </div>
        <span
          class="uuwg-mission__badge uuwg-mission__badge-1 uuwg-mission__badge--top-right"><?php echo esc_html($photo1_badge); ?></span>
      <?php endif; ?>
      </div>

      <!-- Плаваючий бейдж "Connecting" — на стику фото 1 і фото 2 -->
      <?php if ($connecting_badge_text) : ?>
        <span
          class="uuwg-mission__badge uuwg-mission__badge--floating"><?php echo esc_html($connecting_badge_text); ?></span>
      <?php endif; ?>

      <!-- Фото 2 — нижнє ліве -->
      <div class="uuwg-mission__photo uuwg-mission__photo--2">
        <div class="uuwg-mission__photo-frame">
          <img src="<?php echo esc_url($photo2_url); ?>" alt="">
          <?php if ($photo2_badge) : ?>
        </div>
        <span class="uuwg-mission__badge uuwg-mission__badge--top-right"><?php echo esc_html($photo2_badge); ?></span>
      <?php endif; ?>
      </div>

      <!-- Фото 3 — праве, високе -->
      <div class="uuwg-mission__photo uuwg-mission__photo--3">
        <div class="uuwg-mission__photo-frame">
          <img src="<?php echo esc_url($photo3_url); ?>" alt="">
        </div>
      </div>

    </div>
  </div>


</div>