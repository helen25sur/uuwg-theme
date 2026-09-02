<?php

$settings_page = get_page_by_path('site-settings');

if (!$settings_page || !function_exists('get_field')) {
  return;
}

$socials = array(
  'instagram' => get_field('social_instagram', $settings_page->ID),
  'facebook'  => get_field('social_facebook', $settings_page->ID),
  'youtube'   => get_field('social_youtube', $settings_page->ID),
  'linkedin'  => get_field('social_linkedin', $settings_page->ID),
  'telegram'  => get_field('social_telegram', $settings_page->ID),
);

$icons = array(
  'instagram' => get_theme_file_uri() . '/assets/images/social-icons/instagram.svg',
  'facebook'  => get_theme_file_uri() . '/assets/images/social-icons/facebook.svg',
  'youtube'   => get_theme_file_uri() . '/assets/images/social-icons/youtube.svg',
  'linkedin'  => get_theme_file_uri() . '/assets/images/social-icons/linkedin.svg',
  'telegram'  => get_theme_file_uri() . '/assets/images/social-icons/telegram.svg',
);

?>
<div class="uuwg-social-links">
  <?php foreach ($socials as $service => $url) : ?>
    <?php if (!$url) continue; ?>

    <a class="uuwg-social-link uuwg-social-link--<?php echo esc_attr($service); ?>" href="<?php echo esc_url($url); ?>"
      target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($service); ?>">
      <span class="uuwg-social-link__icon" aria-hidden="true"></span>
    </a>

  <?php endforeach; ?>
</div>