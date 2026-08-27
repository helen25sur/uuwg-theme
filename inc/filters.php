<?php

require_once get_template_directory() . '/inc/template-parts.php';

add_action('rest_api_init', function () {
  register_rest_route('uuwg/v1', '/document', [
    'methods'             => 'GET',
    'callback'            => 'uuwg_get_documents',
    'permission_callback' => '__return_true',
  ]);
});

function uuwg_get_documents(WP_REST_Request $request)
{
  $filter = sanitize_key($request->get_param('document_year') ?? 'all');

  $term = ($filter !== 'all')
    ? get_term_by('slug', $filter, 'document_year')
    : null;

  if ($filter !== 'all' && (!$term || is_wp_error($term))) {
    $filter = 'all';
    $term = null;
  }

  $args = [
    'post_type'      => 'document',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
  ];

  if ($filter !== 'all') {
    $args['tax_query'] = [
      [
        'taxonomy' => 'document_year',
        'field'    => 'slug',
        'terms'    => $filter,
      ],
    ];
  }

  $query = new WP_Query($args);

  ob_start();

  if ($query->have_posts()) :
    while ($query->have_posts()) :
      $query->the_post();

      $document = get_post();

      echo uuwg_render_document_card($document);
    endwhile;
  endif;

  wp_reset_postdata();

  return new WP_REST_Response([
    'html' => ob_get_clean(),
  ]);
}
