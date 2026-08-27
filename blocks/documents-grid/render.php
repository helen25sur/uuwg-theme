<?php
require_once get_template_directory() . '/inc/template-parts.php';

$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);

$documents_archive_url = get_post_type_archive_link('document');
$filter = sanitize_key($_GET['document_year'] ?? 'all');
$term = ($filter !== 'all') ? get_term_by('slug', $filter, 'document_year') : null;
if (!$term || is_wp_error($term)) {
  $filter = 'all';
  $term = null;
}

$args = [
  'post_type'      => 'document',
  'posts_per_page' => -1,
  'post_status'    => 'publish',
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
?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-documents-grid alignfull']); ?>>
  <div class="uuwg-documents-grid__content">

    <div class="uuwg-documents-grid__header">
      <h2 class="uuwg-documents-grid__heading">
        <?php echo esc_html($attributes['heading'] ?? ''); ?>
      </h2>

      <!-- Перемикач фільтрів documents -->
      <details id="uuwg-document-filter" class="uuwg-documents-grid__filters js-documents-filters">
        <?php
        $document_years = get_terms([
          'taxonomy'   => 'document_year',
          'hide_empty' => false,
        ]);

        ?>
        <summary class="uuwg-documents-filter__current">
          <?php echo $term ? esc_html($term->name) : esc_html__('All', 'uuwg'); ?>
        </summary>

        <ul class="uuwg-documents-filter__list">
          <li class="uuwg-documents-filter__item <?php echo $filter === 'all' ? 'is-active' : ''; ?>">
            <a href="<?php echo esc_url($documents_archive_url); ?>">
              <?php esc_html_e('All', 'uuwg'); ?>
            </a>
          </li>
          <?php foreach ($document_years as $key => $year) : ?>
            <li class="uuwg-documents-filter__item <?php echo $filter === $year->slug ? 'is-active' : ''; ?>">
              <a href=" <?php echo esc_url(add_query_arg('document_year', $year->slug, $documents_archive_url)); ?>">
                <?php esc_html_e($year->name, 'uuwg'); ?>
              </a>
            </li>

          <?php endforeach; ?>
        </ul>
      </details>
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

          $document = get_post();

          echo uuwg_render_document_card($document);

          ?>

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