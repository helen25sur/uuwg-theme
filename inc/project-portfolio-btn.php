<?php
add_filter('render_block', function ($block_content, $block) {

  if (
    $block['blockName'] !== 'core/button'
    || empty($block['attrs']['className'])
    || strpos($block['attrs']['className'], 'btn__project-portfolio') === false
  ) {
    return $block_content;
  }

  $portfolio_url = function_exists('get_field')
    ? get_field('project_portfolio_url')
    : '';

  if (! $portfolio_url) {
    return '';
  }

  $processor = new WP_HTML_Tag_Processor($block_content);

  if ($processor->next_tag('a')) {
    $processor->set_attribute('href', esc_url($portfolio_url));
  }

  return $processor->get_updated_html();
}, 10, 2);
