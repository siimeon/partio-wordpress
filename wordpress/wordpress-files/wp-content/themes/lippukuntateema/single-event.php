<?php
/**
 * The template for displaying all single events.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php while (have_posts()): the_post(); ?>

      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="entry-header">

          <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

          <div class="entry-meta">
            <?php
              $event_location  = get_post_meta(get_the_ID(), 'lippukuntateema_event_location', true);
              $event_start_date = !empty(get_post_meta(get_the_ID(), 'lippukuntateema_event_date_start', true)) ? date_i18n(get_option('date_format'), get_post_meta(get_the_ID(), 'lippukuntateema_event_date_start', true)) : '';
              $event_end_date = !empty(get_post_meta(get_the_ID(), 'lippukuntateema_event_date_end', true)) ? ' - ' . date_i18n(get_option('date_format'), get_post_meta(get_the_ID(), 'lippukuntateema_event_date_end', true)) : '';
              printf('<span class="event-location">%s</span> | <span class="event-date">%s%s</span>', esc_html($event_location), $event_start_date, $event_end_date);
            ?>
          </div><!-- .entry-meta -->

        </header><!-- .entry-header -->

        <div class="entry-content">
          <?php if(has_post_thumbnail()): ?>
            <div class="post-thumbnail">
              <?php echo get_the_post_thumbnail($post, 'large'); ?>
            </div>
          <?php endif; ?>

          <?php the_content(); ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer">
          <?php lippukuntateema_entry_footer(); ?>
        </footer><!-- .entry-footer -->
      </article><!-- #post-## -->

    <?php endwhile; ?>

    <?php echo lippukuntateema_social_share_buttons(); ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php
get_footer();
