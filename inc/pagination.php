<?php

require_once get_template_directory() . '/inc/template-parts.php';

add_action('rest_api_init', function () {

  register_rest_route('uuwg/v1', '/project', [
    'methods'             => 'GET',
    'callback'            => 'uuwg_get_projects',
    'permission_callback' => '__return_true',
  ]);
});


function uuwg_get_projects(WP_REST_Request $request)
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

  $filter = sanitize_key($request->get_param('project_category'));

  $args = [
    'post_type'      => 'project',
    'post_status'    => 'publish',
    'posts_per_page' => $per_page,
    'offset'         => $offset,
  ];

  $allowed_filters = [
    'featured-projects',
    'past-projects',
  ];

  if (in_array($filter, $allowed_filters, true)) {
    $args['tax_query'] = [
      [
        'taxonomy' => 'project_category',
        'field'    => 'slug',
        'terms'    => $filter,
      ],
    ];
  }

  error_log('FILTER: ' . $filter);

  $term = get_term_by('slug', $filter, 'project_category');

  error_log(print_r($term, true));

  $query = new WP_Query($args);


  ob_start();


  if ($query->have_posts()) :

    while ($query->have_posts()) :
      $query->the_post();

      $ID = get_the_ID();

      echo uuwg_render_project_card($ID, 'Read more');

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


add_action('rest_api_init', function () {

  register_rest_route('uuwg/v1', '/news_event', [
    'methods'             => 'GET',
    'callback'            => 'uuwg_get_news_events',
    'permission_callback' => '__return_true',
  ]);
});


function uuwg_get_news_events(WP_REST_Request $request)
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
    'post_type'      => 'news_event',
    'post_status'    => 'publish',
    'posts_per_page' => $per_page,
    'offset'         => $offset,
  ]);


  ob_start();


  if ($query->have_posts()) :

    while ($query->have_posts()) :
      $query->the_post();

      $ID = get_the_ID();

      $short_description = '';

      if (function_exists('get_field')) {
        $short_description = get_field(
          'news_short_description',
          $ID
        );
      }

      echo uuwg_render_news_card($ID, 'Read more');

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