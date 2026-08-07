<?php

if (! defined('ABSPATH')) {
  exit;
}

if (! isset($attributes) || ! is_array($attributes)) {
  $attributes = [];
}

$dark_logo_url  = $attributes['darkLogo']['url']  ?? '';
$light_logo_url = $attributes['lightLogo']['url'] ?? '';

// Дефолт із теми — спрацьовує, поки адмін нічого не обрав вручну
if (! $dark_logo_url) {
  $dark_logo_url = get_template_directory_uri() . '/assets/images/logo-default-blue.svg';
}
if (! $light_logo_url) {
  $light_logo_url = get_template_directory_uri() . '/assets/images/logo-default-white.svg';
}

?>

<a href="<?php echo esc_url(home_url('/')); ?>" class="uuwg-site-logo">
  <img src="<?php echo esc_url($dark_logo_url); ?>" class="uuwg-site-logo__dark"
    alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
  <img src="<?php echo esc_url($light_logo_url); ?>" class="uuwg-site-logo__light"
    alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
</a>