<?php

function uuwg_contact_info_shortcode($atts)
{
  $atts = shortcode_atts(array(
    'field' => '',
    'type'  => 'auto', // auto, email, phone, address, text
  ), $atts);

  if (empty($atts['field'])) {
    return '';
  }

  $settings_page = get_page_by_path('site-settings');
  if (!$settings_page) {
    return '';
  }

  $value = '';
  if (function_exists('get_field')) {
    $value = get_field($atts['field'], $settings_page->ID);
  }

  if (!$value) {
    return '';
  }

  $type = $atts['type'];
  $field_name = $atts['field'];

  // Автоматичне визначення типу, якщо тип 'auto'
  if ($type === 'auto') {
    if (strpos($field_name, 'email') !== false || is_email($value)) {
      $type = 'email';
    } elseif (strpos($field_name, 'telephone') !== false) {
      $type = 'phone';
    } elseif (strpos($field_name, 'address') !== false) {
      $type = 'address';
    } else {
      $type = 'text';
    }
  }

  // Генерація потрібного посилання
  switch ($type) {
    case 'email':
      return sprintf(
        '<a href="mailto:%1$s" class="uuwg-contact-link">%2$s</a>',
        esc_attr($value),
        esc_html($value)
      );

    case 'phone':
      // Очищаємо номер для атрибута tel: (залишаємо тільки + і цифри)
      $clean_phone = preg_replace('/[^\d+]/', '', $value);
      return sprintf(
        '<a href="tel:%1$s" class="uuwg-contact-link">%2$s</a>',
        esc_attr($clean_phone),
        esc_html($value)
      );

    case 'address':
      $maps_url = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($value);
      return sprintf(
        '<a href="%1$s" target="_blank" rel="noopener noreferrer" class="uuwg-contact-link">%2$s</a>',
        esc_url($maps_url),
        esc_html($value)
      );

    case 'text':
      return esc_html($value);

    default:
      return esc_html($value);
  }
}
add_shortcode('uuwg_contact', 'uuwg_contact_info_shortcode');
