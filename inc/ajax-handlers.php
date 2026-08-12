<?php
// inc/ajax-handlers.php
if (! defined('ABSPATH')) exit;

add_action('wp_ajax_uuwg_get_news', 'uuwg_get_news_ajax_handler');
add_action('wp_ajax_nopriv_uuwg_get_news', 'uuwg_get_news_ajax_handler');

function uuwg_get_news_ajax_handler()
{
  $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
  $count = isset($_POST['count']) ? intval($_POST['count']) : 3;

  $query = new WP_Query([
    'post_type'      => 'news_event',
    'posts_per_page' => $count,
    'paged'          => $page,
  ]);

  ob_start();
  if ($query->have_posts()) {
    while ($query->have_posts()) {
      $query->the_post();
      $ID = get_the_ID();
      $short_description = function_exists('get_field') ? get_field('project_short_description', $ID) : '';
?>
      <div class="uuwg-news-events__card">
        <a class="uuwg-our-project__permalink" href="<?php echo esc_url(get_permalink($ID)); ?>">
          <?php if (has_post_thumbnail()) : ?>
            <?php the_post_thumbnail('medium'); ?>
          <?php endif; ?>
          <div class="uuwg-news-events__card__content">
            <h3 class="uuwg-news-events__card__title"><?php echo esc_html(get_the_title()); ?></h3>
            <?php if ($short_description) : ?>
              <p class="uuwg-news-events__card__short-description"><?php echo esc_html($short_description); ?></p>
            <?php endif; ?>
            <span class="uwg-news-events__card__button">Read more</span>
          </div>
        </a>
      </div>
<?php
    }
  }
  $cards_html = ob_get_clean();

  ob_start();
  $total_pages = $query->max_num_pages;
  if ($total_pages > 1) {
    for ($i = 1; $i <= $total_pages; $i++) {
      $active_class = ($i === $page) ? ' is-active' : '';
      echo '<button type="button" class="uuwg-pagination-news-btn' . $active_class . '" data-page="' . $i . '">' . $i . '</button>';
    }
  }
  $pagination_html = ob_get_clean();

  wp_reset_postdata();

  wp_send_json_success([
    'cards'      => $cards_html,
    'pagination' => $pagination_html,
  ]);
}
