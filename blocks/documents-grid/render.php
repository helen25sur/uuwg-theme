<?php

$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);

$args = array(
  'post_type'      => 'document',
  'posts_per_page' => -1,
  'post_status'    => 'publish',
);

$query = new WP_Query($args);
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-documents-grid alignfull']); ?>>
  <div class="uuwg-documents-grid__content">

    <div class="uuwg-documents-grid__header">
      <h2 class="uuwg-documents-grid__heading">
        <?php echo esc_html($attributes['heading'] ?? ''); ?>
      </h2>
    </div>

    <div class="uuwg-documents-grid__grid">
      <?php if ($query->have_posts()) : ?>
        <?php while ($query->have_posts()) : ?>
          <?php
          $query->the_post();
          $file = function_exists('get_field')
            ? get_field('document_file')
            : null;
          $file_url = $file['url'] ?? '';
          $terms = get_the_terms(get_the_ID(), 'document_type');

          $folder_icon_url = ! empty($attributes['folderIconUrl'])
            ? $attributes['folderIconUrl']
            : get_template_directory_uri() . '/assets/images/folder.png';
          ?>

          <div class="uuwg-documents-grid__card">
            <div class="uuwg-documents-grid__card__img">
              <img src="<?php echo esc_url($folder_icon_url); ?>" alt="Folder image">
            </div>
            <div class="uuwg-documents-grid__card__content">
              <h3 class="uuwg-documents-grid__card__title">
                <?php echo esc_html(get_the_title()); ?>
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
                  <img src="<?php echo get_template_directory_uri() . '/assets/images/download.svg' ?>"
                    alt="icon of downloading">
                </a>
              <?php endif; ?>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else : ?>
        <p class="uuwg-documents-grid__empty">
          <?php echo esc_html__('No documents found.', 'uuwg'); ?>
        </p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php wp_reset_postdata(); ?>