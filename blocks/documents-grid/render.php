<?php
$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);

?>

<section <?php echo get_block_wrapper_attributes(['class' => 'uuwg-documents-grid']); ?>>
  <div class="uuwg-documents-grid__content">
    <div class="uuwg-documents-grid__header">
      <h2 class="uuwg-documents-grid__heading">
        <?php echo esc_html($attributes['heading'] ?? ''); ?>
      </h2>
    </div>
  </div>

</section>