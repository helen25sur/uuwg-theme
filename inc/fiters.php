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
  $page = max(
    1,
    (int) $request->get_param('page')
  );

  $per_page = max(
    1,
    (int) $request->get_param('per_page')
  );
  $offset = max(0, (int) $request->get_param('offset'));

  $query = new WP_Query([
    'post_type'      => 'document',
    'post_status'    => 'publish',
    'posts_per_page' => $per_page,
    'offset'         => $offset,
  ]);


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
    'html'       => ob_get_clean(),
    'offset'     => $offset,
    'totalPages' => (int) $query->max_num_pages,
    'totalItems' => (int) $query->found_posts,
  ]);
}
