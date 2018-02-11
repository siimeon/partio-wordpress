<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  <header class="entry-header">

    <?php
      if ( is_single() ) {
        the_title( '<h1 class="entry-title">', '</h1>' );
      } else {
        the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
      }
    ?>

    <div class="entry-meta">
      <?php lippukuntateema_posted_on(); ?>
    </div><!-- .entry-meta -->

  </header><!-- .entry-header -->

  <div class="entry-content">
    <?php if(has_post_thumbnail()): ?>
      <div class="post-thumbnail">
        <?php
          if ( is_single() ) {
            echo get_the_post_thumbnail($post, 'large');
          } else {
            echo get_the_post_thumbnail($post, 'box');
          }
        ?>
      </div>
    <?php endif; ?>

    <?php the_content(); ?>
  </div><!-- .entry-content -->

  <footer class="entry-footer">
    <?php lippukuntateema_entry_footer(); ?>
  </footer><!-- .entry-footer -->
</article><!-- #post-## -->
