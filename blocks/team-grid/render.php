<?php

/**
 * Server-side render for uuwg/team-grid block.
 *
 * @package UUWG
 */

if (! defined('ABSPATH')) {
  exit;
}

$attributes = isset($attributes) && is_array($attributes)
  ? $attributes
  : (array) ($attributes ?? []);


/*
 * How many projects are loaded from the server
 * at one time.
 */
$per_page = -1;

/*
 * Block settings.
 */

$button_text = $attributes['buttonText'] ?? 'Join us';


/*
 * Initial query.
 *
 * We load the all team members.
 * The rest will be loaded via REST API.
 */
$query = new WP_Query([
  'post_type'      => 'team_member',
  'post_status'    => 'publish',
  'posts_per_page' => $per_page,
  'paged'          => 1,
  'order'          => 'ASC',
]);

?>

<section <?php
          echo get_block_wrapper_attributes([
            'class' => 'uuwg-team-grid alignfull',
          ]);
          ?>>

  <div class="uuwg-team-grid__content">

    <div class="uuwg-team-grid__header">

      <h2 class="uuwg-team-grid__heading">
        <?php echo esc_html($attributes['heading'] ?? ''); ?>
      </h2>

      <a class="uuwg-team-grid__cta wp-element-button uuwg-btn"
        href="<?php echo esc_url($attributes['buttonUrl'] ?? '#'); ?>">
        <?php echo esc_html($button_text); ?>
      </a>

    </div>


    <div class="uuwg-team-grid__grids" data-post-type="team_member" data-per-page="<?php echo esc_attr($per_page); ?>">

      <?php if ($query->have_posts()) : ?>

        <?php while ($query->have_posts()) : $query->the_post(); ?>

          <div class="uuwg-team-grid__card">
            <?php
            $post_id   = get_the_ID();
            $position  = function_exists('get_field')
              ? get_field('member_position', $post_id)
              : get_post_meta($post_id, 'member_position', true);
            $period    = function_exists('get_field')
              ? get_field('member_period', $post_id)
              : get_post_meta($post_id, 'member_period', true);
            $fb_url    = function_exists('get_field')
              ? get_field('member_fb', $post_id)
              : get_post_meta($post_id, 'member_fb', true);
            $tg_url    = function_exists('get_field')
              ? get_field('member_tg', $post_id)
              : get_post_meta($post_id, 'member_tg', true);
            $in_url    = function_exists('get_field')
              ? get_field('member_linkedin', $post_id)
              : get_post_meta($post_id, 'member_linkedin', true);
            ?>

            <?php if (has_post_thumbnail()) : ?>
              <div class="uuwg-team-grid__card__image">
                <?php the_post_thumbnail('medium'); ?>
              </div>
            <?php endif; ?>

            <div class="uuwg-team-grid__card__content ">
              <h3 class="uuwg-team-grid__card__title"><?php the_title(); ?></h3>

              <p class="uuwg-team-grid__card__position"><?php echo esc_html($position); ?></p>

              <div class="uuwg-team-grid__card__footer">
                <?php if ($period) : ?>
                  <span class="uuwg-team-grid__card__period"><?php echo esc_html($period); ?></span>
                <?php endif; ?>

                <div class="uuwg-team-grid__card__socials">
                  <?php if ($fb_url) : ?>
                    <a href="<?php echo esc_url($fb_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                      <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M1.39767 11.0833H3.731V6.41083H5.83333L6.06433 4.08917H3.731V2.91667C3.731 2.76196 3.79246 2.61358 3.90185 2.50419C4.01125 2.39479 4.15962 2.33333 4.31433 2.33333H6.06433V0H4.31433C3.54079 0 2.79892 0.307291 2.25194 0.854272C1.70496 1.40125 1.39767 2.14312 1.39767 2.91667V4.08917H0.231L0 6.41083H1.39767V11.0833Z"
                          fill="#F8F6EE" />
                      </svg>
                    </a>
                  <?php endif; ?>

                  <?php if ($tg_url) : ?>
                    <a href="<?php echo esc_url($tg_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="Telegram">
                      <svg width="12" height="11" viewBox="0 0 12 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M10.5099 0.0685213C10.654 0.00784935 10.8118 -0.013076 10.9668 0.007923C11.1218 0.028922 11.2683 0.0910779 11.3911 0.187921C11.5139 0.284764 11.6085 0.412754 11.6651 0.558569C11.7216 0.704385 11.7381 0.862695 11.7127 1.01702L10.3897 9.04194C10.2613 9.81602 9.41202 10.2599 8.7021 9.87435C8.10827 9.55177 7.22627 9.05477 6.43293 8.53619C6.03627 8.2766 4.82118 7.44535 4.97052 6.85385C5.09885 6.3481 7.14052 4.4476 8.30718 3.31769C8.7651 2.87377 8.55627 2.61769 8.01552 3.02602C6.67268 4.03985 4.51668 5.5816 3.80385 6.0156C3.17502 6.39827 2.84718 6.4636 2.45518 6.39827C1.74002 6.27927 1.07677 6.09494 0.535435 5.87035C-0.196065 5.56702 -0.160482 4.56135 0.534851 4.26852L10.5099 0.0685213Z"
                          fill="#F8F6EE" />
                      </svg>
                    </a>
                  <?php endif; ?>

                  <?php if ($in_url) : ?>
                    <a href="<?php echo esc_url($in_url); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                      <svg width="11" height="12" viewBox="0 0 11 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                          d="M1.23958 0C0.910825 0 0.595533 0.130599 0.363066 0.363066C0.130599 0.595533 0 0.910825 0 1.23958C0 1.56834 0.130599 1.88363 0.363066 2.1161C0.595533 2.34857 0.910825 2.47917 1.23958 2.47917C1.56834 2.47917 1.88363 2.34857 2.1161 2.1161C2.34857 1.88363 2.47917 1.56834 2.47917 1.23958C2.47917 0.910825 2.34857 0.595533 2.1161 0.363066C1.88363 0.130599 1.56834 0 1.23958 0ZM0.0729167 3.5C0.053578 3.5 0.0350313 3.50768 0.0213567 3.52136C0.00768221 3.53503 0 3.55358 0 3.57292V11.1562C0 11.1965 0.0326667 11.2292 0.0729167 11.2292H2.40625C2.42559 11.2292 2.44414 11.2215 2.45781 11.2078C2.47148 11.1941 2.47917 11.1756 2.47917 11.1562V3.57292C2.47917 3.55358 2.47148 3.53503 2.45781 3.52136C2.44414 3.50768 2.42559 3.5 2.40625 3.5H0.0729167ZM3.86458 3.5C3.84524 3.5 3.8267 3.50768 3.81302 3.52136C3.79935 3.53503 3.79167 3.55358 3.79167 3.57292V11.1562C3.79167 11.1965 3.82433 11.2292 3.86458 11.2292H6.19792C6.21726 11.2292 6.2358 11.2215 6.24948 11.2078C6.26315 11.1941 6.27083 11.1756 6.27083 11.1562V7.07292C6.27083 6.78284 6.38607 6.50464 6.59118 6.29952C6.7963 6.0944 7.0745 5.97917 7.36458 5.97917C7.65466 5.97917 7.93286 6.0944 8.13798 6.29952C8.3431 6.50464 8.45833 6.78284 8.45833 7.07292V11.1562C8.45833 11.1965 8.491 11.2292 8.53125 11.2292H10.8646C10.8839 11.2292 10.9025 11.2215 10.9161 11.2078C10.9298 11.1941 10.9375 11.1756 10.9375 11.1562V6.12792C10.9375 4.71217 9.70667 3.605 8.29792 3.73275C7.86209 3.77273 7.43518 3.88059 7.03267 4.05242L6.27083 4.37908V3.57292C6.27083 3.55358 6.26315 3.53503 6.24948 3.52136C6.2358 3.50768 6.21726 3.5 6.19792 3.5H3.86458Z"
                          fill="#F8F6EE" />
                      </svg>

                    </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>

          </div>

        <?php endwhile; ?>

      <?php else : ?>

        <p class="uuwg-team-grid__empty">
          <?php esc_html_e('No projects found.', 'uuwg'); ?>
        </p>

      <?php endif; ?>
    </div>

    <?php wp_reset_postdata(); ?>

  </div>

</section>