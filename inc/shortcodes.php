<?php

function uuwg_setting_shortcode($atts)
{
  $atts = shortcode_atts(
    array(
      'field' => '',
      'type'  => 'auto', // auto, email, phone, address, url, text
    ),
    $atts
  );

  if (empty($atts['field'])) {
    return '';
  }

  $settings_page = get_page_by_path('site-settings');

  if (!$settings_page) {
    return '';
  }

  if (!function_exists('get_field')) {
    return '';
  }

  $value = get_field($atts['field'], $settings_page->ID);

  if (!$value) {
    return '';
  }

  $type = $atts['type'];
  $field_name = $atts['field'];

  // Автоматичне визначення типу
  if ($type === 'auto') {
    if (strpos($field_name, 'email') !== false || is_email($value)) {
      $type = 'email';
    } elseif (
      strpos($field_name, 'telephone') !== false ||
      strpos($field_name, 'phone') !== false
    ) {
      $type = 'phone';
    } elseif (strpos($field_name, 'address') !== false) {
      $type = 'address';
    } elseif (filter_var($value, FILTER_VALIDATE_URL)) {
      $type = 'url';
    } else {
      $type = 'text';
    }
  }

  switch ($type) {

    case 'email':
      return sprintf(
        '<a href="mailto:%1$s" class="uuwg-setting-link">%2$s</a>',
        esc_attr($value),
        esc_html($value)
      );

    case 'phone':
      $clean_phone = preg_replace('/[^\d+]/', '', $value);

      return sprintf(
        '<a href="tel:%1$s" class="uuwg-setting-link">%2$s</a>',
        esc_attr($clean_phone),
        esc_html($value)
      );

    case 'address':
      $maps_url = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($value);

      return sprintf(
        '<a href="%1$s" target="_blank" rel="noopener noreferrer" class="uuwg-setting-link">%2$s</a>',
        esc_url($maps_url),
        esc_html($value)
      );

    case 'url':
      return sprintf(
        '<a href="%1$s" target="_blank" rel="noopener noreferrer" class="uuwg-setting-link">%2$s</a>',
        esc_url($value),
        esc_html($value)
      );

    case 'text':
    default:
      return esc_html($value);
  }
}

add_shortcode('uuwg_setting', 'uuwg_setting_shortcode');

function uuwg_donate_shortcode()
{
    $settings_page = get_page_by_path('site-settings');

    if (!$settings_page || !function_exists('get_field')) {
        return '';
    }

    $donate_url = get_field('donate_url', $settings_page->ID);

    if (!$donate_url) {
        return '';
    }

    return sprintf(
        '<div class="wp-block-buttons">
            <div class="wp-block-button">
                <a class="wp-block-button__link wp-element-button"
                   href="%1$s"
                   target="_blank"
                   rel="noreferrer noopener">Donate</a>
            </div>
        </div>',
        esc_url($donate_url)
    );
}

add_shortcode('uuwg_donate', 'uuwg_donate_shortcode');