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
 * Language switcher shortcode.
 *
 * Usage:
 * [uuwg_language_switcher]
 */
function uuwg_language_switcher_shortcode()
{

  if (! function_exists('pll_the_languages')) {
    return '';
  }


  $languages = pll_the_languages(
    array(
      'raw' => 1,
    )
  );


  if (empty($languages)) {
    return '';
  }


  $labels = array(
    'en' => 'ENG',
    'uk' => 'UKR',
  );


  ob_start();
?>

<select class="uuwg-language-switcher" aria-label="<?php esc_attr_e('Language switcher', 'uuwg'); ?>"
  onchange="if(this.value) window.location.href=this.value;">

  <?php foreach ($languages as $language) : ?>

  <option value="<?php echo esc_url($language['url']); ?>" <?php selected($language['current_lang'], 1); ?>>

    <?php
        echo esc_html(
          $labels[$language['slug']] ?? $language['name']
        );
        ?>

  </option>

  <?php endforeach; ?>

</select>


<?php

  return ob_get_clean();
}


add_shortcode(
  'uuwg_language_switcher',
  'uuwg_language_switcher_shortcode'
);