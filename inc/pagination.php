<?php

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


  $query = new WP_Query([
    'post_type'      => 'project',
    'post_status'    => 'publish',
    'posts_per_page' => $per_page,
    'offset'         => ($page - 1) * $per_page,
  ]);


  ob_start();


  if ($query->have_posts()) :

    while ($query->have_posts()) :
      $query->the_post();

      $ID = get_the_ID();

      $short_description = '';

      if (function_exists('get_field')) {
        $short_description = get_field(
          'project_short_description',
          $ID
        );
      }
?>

      <div class="uuwg-our-projects__card uuwg-carousel__item">

        <a class="uuwg-our-project__permalink" href="<?php echo esc_url(get_permalink($ID)); ?>">

          <?php
          $thumbnail = get_the_post_thumbnail();

          if ($thumbnail) {
            echo $thumbnail;
          }
          ?>

          <div class="uuwg-our-projects__card__content">

            <h3 class="uuwg-our-projects__card__title">
              <?php echo esc_html(get_the_title()); ?>
            </h3>

            <p class="uuwg-our-projects__card__short-description">
              <?php echo esc_html($short_description); ?>
            </p>

            <span class="uuwg-our-projects__card__button">
              <?php
              echo esc_html(
                'Read more'
              );
              ?>
            </span>

          </div>

        </a>

      </div>

    <?php
    endwhile;

  endif;


  wp_reset_postdata();


  return new WP_REST_Response([
    'html' => ob_get_clean(),

    'currentPage' => $page,

    'totalPages' =>
    (int) $query->max_num_pages,

    'totalItems' =>
    (int) $query->found_posts,
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


  $query = new WP_Query([
    'post_type'      => 'news_event',
    'post_status'    => 'publish',
    'posts_per_page' => $per_page,
    'offset'         => ($page - 1) * $per_page,
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
    ?>

      <div class="uuwg-news-events__card uuwg-carousel__item">

        <a class="uuwg-news-events__permalink" href="<?php echo esc_url(get_permalink($ID)); ?>">

          <?php if (has_post_thumbnail()) : ?>

            <?php the_post_thumbnail('medium'); ?>

          <?php endif; ?>


          <div class="uuwg-news-events__card__content">

            <h3 class="uuwg-news-events__card__title">
              <?php echo esc_html(get_the_title()); ?>
            </h3>


            <?php if ($short_description) : ?>

              <p class="uuwg-news-events__card__short-description">
                <?php echo esc_html($short_description); ?>
              </p>

            <?php endif; ?>


            <span class="uuwg-news-events__card__button">
              <?php echo esc_html('Read more'); ?>
            </span>

          </div>

        </a>

      </div>

<?php
    endwhile;

  endif;


  wp_reset_postdata();


  return new WP_REST_Response([
    'html' => ob_get_clean(),

    'currentPage' =>
    $page,

    'totalPages' =>
    (int) $query->max_num_pages,

    'totalItems' =>
    (int) $query->found_posts,
  ]);
}
