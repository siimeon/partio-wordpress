<article id="post-<?php the_ID(); ?>" <?php post_class('teaser'); ?>>
  <?php if(has_post_thumbnail()): ?>
    <div class="post-thumbnail">
      <a href="<?php echo esc_url(get_permalink()); ?>">
        <?php echo get_the_post_thumbnail($post, 'box'); ?>
      </a>
    </div>
  <?php endif; ?>

  <header class="entry-header">
    <?php the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' ); ?>
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
    <?php the_excerpt(); ?>
  </div><!-- .entry-content -->

  <footer class="entry-footer">
    <a class="read-more" href="<?php echo get_permalink(); ?>">Lue lisää<?php echo lippukuntateema_get_svg('caret-right'); ?></a>
  </footer>
</article><!-- #post-## -->
