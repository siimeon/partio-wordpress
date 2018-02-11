<?php
/**
 * The template for displaying event archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

      <header class="page-header">
        <?php
          the_archive_title( '<h1 class="page-title">', '</h1>' );
          the_archive_description( '<div class="taxonomy-description">', '</div>' );
        ?>
      </header><!-- .page-header -->

      <?php
        $yesterday = current_time('timestamp') - 24 * 60 * 60;
        $args = array(
          'post_type' => array('event'),
          'meta_key' => 'lippukuntateema_event_date_start',
          'orderby' => 'meta_value_num',
          'order' => 'ASC',
          'meta_query' => array(
            array(
              'relation' => 'OR',
              array(
                'relation' => 'AND',
                array(
                  'key' => 'lippukuntateema_event_date_end',
                  'compare' => 'EXITS',
                ),
                array(
                  'key' => 'lippukuntateema_event_date_end',
                  'compare' => '>',
                  'value' => $yesterday,
                ),
              ),
              array(
                'key' => 'lippukuntateema_event_date_start',
                'compare' => '>',
                'value' => $yesterday,
              ),
            )
          ),
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
          while ($query->have_posts()) {
            $query->the_post();
            get_template_part('template-parts/teaser', 'event');
          }
          lippukuntateema_numeric_posts_nav($query);
        } else {
          get_template_part('template-parts/content', 'none');
        }
        wp_reset_postdata();
      ?>

    </main><!-- #main -->
  </div><!-- #primary -->

<?php
get_footer();
