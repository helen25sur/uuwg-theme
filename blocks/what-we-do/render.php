<?php

/**
 * Server-side render for uuwg/what-we-do block.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
  exit;
}

$heading     = $attributes['heading'] ?? '';
$button_text = $attributes['buttonText'] ?? '';
$button_url  = $attributes['buttonUrl'] ?? '#';

$items = array();
for ($i = 1; $i <= 5; $i++) {
  $items[] = array(
    'title'   => $attributes["item{$i}Title"] ?? '',
    'text'    => $attributes["item{$i}Text"] ?? '',
    'linkUrl' => $attributes["item{$i}LinkUrl"] ?? '#',
  );
}

$wrapper_attributes = get_block_wrapper_attributes(
  array('class' => 'uuwg-what-we-do alignfull')
);
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput 
      ?>>
  <div class="container">
    <div class="uuwg-what-we-do__header">
      <h2 class="uuwg-what-we-do__heading"><?php echo wp_kses_post($heading); ?></h2>
      <a class="uuwg-what-we-do__cta wp-element-button" href="<?php echo esc_url($button_url); ?>">
        <?php echo esc_html($button_text); ?>
      </a>
    </div>

    <div class="uuwg-what-we-do__cards" data-uuwg-accordion>
      <?php foreach ($items as $index => $item) : ?>
      <?php $is_active = (0 === $index); // перша картка відкрита за замовчуванням 
      ?>
      <div class="uuwg-what-we-do__card<?php echo $is_active ? ' is-active' : ''; ?>"
        data-index="<?php echo esc_attr($index); ?>">
        <h3 class="uuwg-what-we-do__card-title"><?php echo esc_html($item['title']); ?></h3>

        <?php if ($item['text']) : ?>
        <div class="uuwg-what-we-do__card-text"><?php echo wp_kses_post($item['text']); ?></div>
        <?php endif; ?>

        <button type="button" class="uuwg-what-we-do__card-toggle"
          aria-label="<?php esc_attr_e('Toggle details', 'uuwg'); ?>">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 8H13M13 8L9 4M13 8L9 12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </button>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>