<?php
// Ensure $attributes is defined to avoid PHP notices when this template is rendered directly.
$attributes = isset($attributes) && is_array($attributes) ? $attributes : (array) ($attributes ?? []);

$socials = [
  'instagram',
  'facebook',
  'youtube',
  'linkedin',
  'telegram',
  'copy',
];
?>

<div <?php echo get_block_wrapper_attributes(['class' => 'uuwg-socials-share']); ?>>
  <ul class="uuwg-socials-share__list">
    <?php foreach ($socials as $social) : ?>
    <?php
      $label_key = "{$social}Label";
      $button_label = $attributes[$label_key] ?? '';
      $icon_url = get_template_directory_uri() . "/assets/images/social-icons/{$social}.svg";
      ?>
    <li class="uuwg-socials-share__item uuwg-socials-share__item--<?php echo esc_attr($social); ?>">
      <button class="uuwg-socials-share__button" data-social="<?php echo esc_attr($social); ?>"
        aria-label="<?php echo esc_attr($button_label); ?>">
        <span class="uuwg-socials-share__button__icon" style="--icon-url: url('<?php echo esc_url($icon_url); ?>');">
        </span>
      </button>
    </li>
    <?php endforeach; ?>
  </ul>

  <div class="uuwg-copy-notification" aria-live="polite">
    Link copied
  </div>

</div>