<?php
if (! defined('ABSPATH')) {
  exit;
}

function uuwg_add_body_classes($classes)
{
  // Зараз hero тільки на Home; якщо з'явиться на інших сторінках —
  // розширити умову (наприклад is_page_template('page-about.html')).
  if (is_front_page()) {
    $classes[] = 'has-hero';
  }
  return $classes;
}
add_filter('body_class', 'uuwg_add_body_classes');
