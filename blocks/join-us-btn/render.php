<?php
$settings_page = get_page_by_path('site-settings');

if (!$settings_page || !function_exists('get_field')) {
  return;
}

$linkTelegram = get_field('social_telegram', $settings_page->ID);

?>

<div class="chat_button__container">
  <a href="<?php echo $linkTelegram; ?>" target="_blank" rel="noopener noreferrer"
    aria-label="Join Us: Telegram Channel" class="chat_button__link">Join our
    chat</a>
</div>