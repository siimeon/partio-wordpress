<?php
/**
 * The template for displaying posts page.
 **/

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
      <?php
        $page_id = get_option('page_for_posts');
        $page_content = get_post($page_id);
        $content = $page_content->post_content;
      ?>

      <h1 class="page-title"><?php echo get_the_title($page_id); ?></h1>

      <?php echo do_shortcode($content); ?>

      <?php
        while ( have_posts() ) : the_post();
          get_template_part( 'template-parts/teaser', 'post' );
        endwhile;
        lippukuntateema_numeric_posts_nav();
      ?>

      <?php echo lippukuntateema_social_share_buttons(); ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
