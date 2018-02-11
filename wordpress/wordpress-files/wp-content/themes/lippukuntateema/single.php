<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

    <?php
      while ( have_posts() ) : the_post();

        get_template_part( 'template-parts/content', get_post_format() );

      endwhile;
    ?>

    <?php echo lippukuntateema_social_share_buttons(); ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php
get_footer();
