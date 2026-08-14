<?php

function uuwg_contact_info_shortcode($atts)
{
  $atts = shortcode_atts(array('field' => ''), $atts);

  $settings_page = get_page_by_path('site-settings'); // slug сторінки, яку створила
  if (! $settings_page) {
    return '';
  }

  $value = '';
  if (function_exists('get_field')) {
    $value = get_field($atts['field'], $settings_page->ID);
  }
  return $value ? esc_html($value) : 'Here should be shortcode';
}
add_shortcode('uuwg_contact', 'uuwg_contact_info_shortcode');