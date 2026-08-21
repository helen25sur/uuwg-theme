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