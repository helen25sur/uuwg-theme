<?php
add_filter('mc4wp_form_redirect_url', function ($url, $form) {

  if ((int) $form->ID !== 156) {
    return $url;
  }

  if (empty($_POST['uuwg_return_url'])) {
    return $url;
  }

  $return_url = esc_url_raw(
    wp_unslash($_POST['uuwg_return_url'])
  );

  $return_url = wp_validate_redirect(
    $return_url,
    home_url('/')
  );

  return add_query_arg(
    'subscription',
    'success',
    $return_url
  );
}, 10, 2);
