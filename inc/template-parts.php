<?php

function uuwg_render_project_card(int $post_id, $button_text = '')
{
  $short_description = '';

  if (function_exists('get_field')) {
    $short_description = get_field('project_short_description', $post_id);
  }

  // Запускаємо буферизацію виводу
  ob_start();
?>
  <div class="uuwg-our-projects__card uuwg-carousel__item">
    <a class="uuwg-our-project__permalink" href="<?php echo esc_url(get_permalink($post_id)); ?>">

      <?php
      $thumbnail = get_the_post_thumbnail($post_id);
      if ($thumbnail) {
        echo $thumbnail;
      }
      ?>

      <div class="uuwg-our-projects__card__content">
        <h3 class="uuwg-our-projects__card__title">
          <?php echo esc_html(get_the_title($post_id)); ?>
        </h3>

        <p class="uuwg-our-projects__card__short-description">
          <?php echo esc_html($short_description); ?>
        </p>

        <span class="uuwg-our-projects__card__button">
          <?php echo esc_html($button_text); ?>
        </span>
      </div>

    </a>
  </div>
<?php
  // Повертаємо збережений вміст буфера у вигляді рядка
  return ob_get_clean();
}


function uuwg_render_news_card(int $post_id, $button_text = '')
{
  $short_description = '';

  if (function_exists('get_field')) {
    $short_description = get_field('news_short_description', $post_id);
  }

  // Запускаємо буферизацію виводу
  ob_start();
?>
  <div class="uuwg-news-events__card uuwg-carousel__item">
    <a class="uuwg-news-events__permalink" href="<?php echo esc_url(get_permalink($post_id)); ?>">

      <?php
      $thumbnail = get_the_post_thumbnail($post_id);
      if ($thumbnail) {
        echo $thumbnail;
      }
      ?>

      <div class="uuwg-news-events__card__content">
        <h3 class="uuwg-news-events__card__title">
          <?php echo esc_html(get_the_title($post_id)); ?>
        </h3>

        <p class="uuwg-news-events__card__short-description">
          <?php echo esc_html($short_description); ?>
        </p>

        <span class="uuwg-news-events__card__button">
          <?php echo esc_html($button_text); ?>
        </span>
      </div>

    </a>
  </div>
<?php
  // Повертаємо збережений вміст буфера у вигляді рядка
  return ob_get_clean();
}


function uuwg_render_document_card(WP_Post $document)
{
  $terms = get_the_terms($document->ID, 'document_type');
  $file = function_exists('get_field')
    ? get_field('document_file', $document->ID)
    : null;

  $file_url = $file['url'] ?? '';
  $folder_icon_url = get_template_directory_uri() . '/assets/images/folder.png';

  ob_start();
?>
  <div class="uuwg-documents-grid__card">
    <div class="uuwg-documents-grid__card__img">
      <img src="<?php echo esc_url($folder_icon_url); ?>" alt="Folder image">
    </div>
    <div class="uuwg-documents-grid__card__content">
      <h3 class="uuwg-documents-grid__card__title">
        <?php echo esc_html(get_the_title($document->ID)); ?>
      </h3>
      <?php if (!is_wp_error($terms) && !empty($terms)) : ?>
        <div class="uuwg-documents-grid__card__type">
          <?php foreach ($terms as $term) : ?>
            <span class="uuwg-documents-grid__card__type-name">
              <?php echo esc_html($term->name); ?>
            </span>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <?php if ($file_url) : ?>
        <a class="uuwg-documents-grid__card__button" href="<?php echo esc_url($file_url); ?>" download>
          <span class="uuwg-documents-grid__card__button__text">
            <?php echo esc_html__('Download', 'uuwg'); ?>
          </span>
          <img src="<?php echo get_template_directory_uri() . '/assets/images/download.svg' ?>" alt="icon of downloading">
        </a>
      <?php endif; ?>
    </div>
  </div>
<?php
  return ob_get_clean();
}
