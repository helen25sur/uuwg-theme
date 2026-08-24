<?php
// Ensure $attributes is defined to avoid PHP notices when this template is rendered directly.
$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);
?>

<div <?php echo get_block_wrapper_attributes(['class' => 'uuwg-socials-share']); ?>>
  <ul class="uuwg-socials-share__list">
    <?php for ($i = 1; $i <= 6; $i++) : ?>
      <?php
      $icon_key = "button{$i}Icon";
      $button_label_key = "button{$i}Label";
      $icon_url = isset($attributes[$icon_key]) ? $attributes[$icon_key] : '';
      $button_label = isset($attributes[$button_label_key]) ? $attributes[$button_label_key] : '';

      if (empty($icon_url)) {
        continue;
      }
      ?>
      <li class="uuwg-socials-share__item">
        <button class="uuwg-socials-share__button" aria-label="<?php echo esc_attr($button_label); ?>">
          <span class="uuwg-socials-share__button__icon" style="--icon-url: url('<?php echo esc_url($icon_url); ?>');">
          </span>
        </button>
      </li>
    <?php endfor; ?>
  </ul>

</div>