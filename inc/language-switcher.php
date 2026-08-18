<?php

/**
 * UUWG Language Switcher.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
  exit;
}

/**
 * Language switcher shortcode using <details>.
 *
 * Usage:
 * [uuwg_language_switcher]
 */
function uuwg_language_switcher_shortcode()
{
  if (! function_exists('pll_the_languages')) {
    return '';
  }

  $languages = pll_the_languages(array('raw' => 1));

  if (empty($languages)) {
    return '';
  }

  $labels = array(
    'en' => 'ENG',
    'uk' => 'UKR',
  );

  // Знаходимо поточну мову для відображення у кнопці <summary>
  $current_label = 'ENG';
  foreach ($languages as $language) {
    if (! empty($language['current_lang'])) {
      $current_label = $labels[$language['slug']] ?? $language['name'];
      break;
    }
  }

  ob_start();
?>

  <details class="uuwg-language-switcher">
    <summary class="uuwg-language-switcher__current" aria-label="<?php esc_attr_e('Language switcher', 'uuwg'); ?>">
      <?php echo esc_html($current_label); ?>
    </summary>

    <ul class="uuwg-language-switcher__list">
      <?php foreach ($languages as $language) :
        $label = $labels[$language['slug']] ?? $language['name'];
        $is_current = ! empty($language['current_lang']);
      ?>
        <li class="uuwg-language-switcher__item">
          <a href="<?php echo esc_url($language['url']); ?>"
            class="uuwg-language-switcher__link<?php echo $is_current ? ' is-active' : ''; ?>">
            <?php echo esc_html($label); ?>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>
  </details>

<?php
  return ob_get_clean();
}

add_shortcode('uuwg_language_switcher', 'uuwg_language_switcher_shortcode');
