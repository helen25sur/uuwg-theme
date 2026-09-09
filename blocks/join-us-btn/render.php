<?php
$settings_page = get_page_by_path('site-settings');

if (!$settings_page || !function_exists('get_field')) {
  return;
}

$linkTelegram = get_field('social_telegram', $settings_page->ID);

?>

<!-- wp:buttons -->
<div class="wp-block-buttons">
  <!-- wp:button {"className":"is-style-outline chat_button__link"} -->
  <div class="wp-block-button is-style-outline chat_button__link">
    <a href="<?php echo $linkTelegram; ?>" target="_blank" rel="noopener noreferrer"
      aria-label="Join Us: Telegram Channel" class="wp-block-button__link wp-element-button">Join our
      chat</a>
  </div>
  <!-- /wp:button -->
</div>
<!-- /wp:buttons -->